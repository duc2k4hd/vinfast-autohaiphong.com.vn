<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Shared\MediaService;
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
     * Thư viện ảnh tập trung Admin.
     */
    public function index(Request $request): View
    {
        $folder = $request->query('folder');

        $query = DB::table('media');

        if ($folder && in_array($folder, ['products', 'banners', 'business', 'posts'])) {
            $query->where('path', 'like', "clients/assets/images/{$folder}/%");
        }

        $mediaItems = $query->orderBy('created_at', 'desc')->paginate(24);

        return view('admin.media.index', [
            'mediaItems' => $mediaItems,
            'currentFolder' => $folder,
        ]);
    }

    /**
     * Tải lên tệp media mới.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:webp,png,jpg,jpeg,svg', 'max:5120'], // tối đa 5MB
            'folder' => ['required', 'in:products,banners,business,posts'],
            'alt_text' => ['nullable', 'string', 'max:255'],
        ], [
            'file.required' => 'Vui lòng chọn một tệp ảnh để tải lên.',
            'file.mimes' => 'Định dạng ảnh được chấp nhận: webp, png, jpg, jpeg, svg.',
            'file.max' => 'Dung lượng ảnh tối đa là 5MB.',
        ]);

        $uploadedFile = $request->file('file');
        $folder = $request->input('folder');
        $altText = $request->input('alt_text') ?: $uploadedFile->getClientOriginalName();

        $destinationFolder = public_path("storage/clients/assets/images/{$folder}");
        if (! File::exists($destinationFolder)) {
            File::makeDirectory($destinationFolder, 0755, true);
        }

        $safeName = Str::slug(pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME)).'-'.time().'.'.$uploadedFile->getClientOriginalExtension();
        $uploadedFile->move($destinationFolder, $safeName);

        $relPath = "clients/assets/images/{$folder}/{$safeName}";
        $fullPath = $destinationFolder.'/'.$safeName;
        $fileSize = File::exists($fullPath) ? File::size($fullPath) : 0;
        $checksum = File::exists($fullPath) ? hash_file('sha256', $fullPath) : null;

        $now = now();
        DB::table('media')->insert([
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
