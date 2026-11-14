<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Shared\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function __construct(
        protected MediaService $mediaService
    ) {}

    /**
     * Thư viện ảnh tập trung Admin kèm bộ lọc tìm kiếm.
     */
    public function index(Request $request): View
    {
        $folder = $request->query('folder');
        $search = $request->query('search');

        $query = DB::table('media');

        if ($folder && in_array($folder, ['products', 'banners', 'business', 'posts'])) {
            $query->where('path', 'like', "clients/assets/images/{$folder}/%");
        }

        if (! empty($search)) {
            $cleanSearch = trim($search);
            $query->where(function ($q) use ($cleanSearch) {
                $q->where('filename', 'like', "%{$cleanSearch}%")
                    ->orWhere('alt_text', 'like', "%{$cleanSearch}%");
            });
        }

        $mediaItems = $query->orderBy('created_at', 'desc')->paginate(24)->withQueryString();

        return view('admin.media.index', [
            'mediaItems' => $mediaItems,
            'currentFolder' => $folder,
            'currentSearch' => $search,
        ]);
    }

    /**
     * API tải danh sách media JSON phân trang siêu tốc (Tận dụng Primary Key Index cho hàng triệu ảnh).
     */
    public function apiList(Request $request): JsonResponse
    {
        $search = trim($request->query('search', ''));
        $perPage = (int) $request->query('per_page', 36);
        $perPage = max(12, min(72, $perPage));

        $query = DB::table('media')
            ->select(['id', 'path', 'filename', 'original_filename', 'alt_text', 'file_size', 'created_at']);

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('filename', 'like', "%{$search}%")
                    ->orWhere('alt_text', 'like', "%{$search}%")
                    ->orWhere('original_filename', 'like', "%{$search}%");
            });
        }

        // Tối ưu hóa truy vấn bằng ID desc dựa trên Primary Key B-Tree index
        $paginator = $query->orderBy('id', 'desc')->paginate($perPage);

        $items = collect($paginator->items())->map(function ($item) {
            return [
                'id' => $item->id,
                'filename' => $item->filename,
                'original_filename' => $item->original_filename ?: $item->filename,
                'alt_text' => $item->alt_text ?: $item->filename,
                'path' => $item->path,
                'url' => asset('storage/'.ltrim($item->path, '/')),
                'file_size' => $item->file_size ? round($item->file_size / 1024, 1).' KB' : '',
                'created_at' => $item->created_at ? date('d/m/Y H:i', strtotime($item->created_at)) : '',
            ];
        });

        return response()->json([
            'items' => $items,
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'total' => $paginator->total(),
            'has_more' => $paginator->hasMorePages(),
        ]);
    }

    /**
     * Tải lên tệp media mới (Hỗ trợ Web Form, TinyMCE và Popup Media Manager với batch đa luồng).
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:webp,png,jpg,jpeg,svg,gif,avif', 'max:5120'], // tối đa 5MB
            'folder' => ['nullable', 'in:products,banners,business,posts'],
            'alt_text' => ['nullable', 'string', 'max:255'],
        ], [
            'file.required' => 'Vui lòng chọn một tệp ảnh để tải lên.',
            'file.mimes' => 'Định dạng ảnh được chấp nhận: webp, png, jpg, jpeg, svg, gif, avif.',
            'file.max' => 'Dung lượng ảnh tối đa là 5MB.',
        ]);

        $uploadedFile = $request->file('file');
        $folder = $request->input('folder', 'products');
        $altText = $request->input('alt_text') ?: pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

        $destinationFolder = public_path("storage/clients/assets/images/{$folder}");
        if (! File::exists($destinationFolder)) {
            File::makeDirectory($destinationFolder, 0755, true);
        }

        $safeName = Str::slug(pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME)).'-'.time().'-'.Str::random(4).'.'.$uploadedFile->getClientOriginalExtension();
        $uploadedFile->move($destinationFolder, $safeName);

        $relPath = "clients/assets/images/{$folder}/{$safeName}";
        $fullPath = $destinationFolder.'/'.$safeName;
        $fileSize = File::exists($fullPath) ? File::size($fullPath) : 0;
        $checksum = File::exists($fullPath) ? hash_file('sha256', $fullPath) : null;

        $now = now();
        $insertedId = DB::table('media')->insertGetId([
            'uuid' => (string) Str::uuid(),
            'folder_id' => null,
            'disk' => 'public',
            'filename' => $safeName,
            'original_filename' => $uploadedFile->getClientOriginalName(),
            'extension' => $uploadedFile->getClientOriginalExtension(),
            'path' => $relPath,
            'mime_type' => File::mimeType($fullPath) ?: 'image/jpeg',
            'file_size' => $fileSize,
            'checksum_sha256' => $checksum,
            'alt_text' => $altText,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            $itemData = [
                'id' => $insertedId,
                'media_id' => $insertedId,
                'path' => $relPath,
                'url' => asset('storage/'.$relPath),
                'filename' => $safeName,
                'original_filename' => $uploadedFile->getClientOriginalName(),
                'alt_text' => $altText,
                'file_size' => round($fileSize / 1024, 1).' KB',
            ];

            return response()->json(array_merge([
                'success' => true,
                'location' => asset('storage/'.$relPath),
                'item' => $itemData,
            ], $itemData));
        }

        return redirect()->route('admin.media.index', ['folder' => $folder])
            ->with('success', 'Đã tải lên tệp ảnh mới và lưu trữ tập trung thành công!');
    }

    /**
     * Xóa tệp media.
     */
    public function destroy(int $id): RedirectResponse
    {
        $media = DB::table('media')->where('id', $id)->first();
        if (! $media) {
            abort(404);
        }

        // Xóa file vật lý trên đĩa
        $fullPath = public_path('storage/'.$media->path);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }

        DB::table('media')->where('id', $id)->delete();

        return back()->with('success', 'Đã xóa tệp media thành công.');
    }
}
