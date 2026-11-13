<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Danh sách bài viết tin tức trong trang quản trị.
     */
    public function index(): View
    {
        $posts = DB::table('posts')
            ->leftJoin('media', 'posts.featured_media_id', '=', 'media.id')
            ->select([
                'posts.id',
                'posts.title',
                'posts.slug',
                'posts.status',
                'posts.published_at',
                'posts.created_at',
                'media.path as thumbnail_path',
            ])
            ->whereNull('posts.deleted_at')
            ->orderBy('posts.created_at', 'desc')
            ->paginate(15);

        return view('admin.posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Giao diện tạo bài viết mới.
     */
    public function create(): View
    {
        $mediaList = DB::table('media')->orderBy('created_at', 'desc')->limit(30)->get();

        return view('admin.posts.create', [
            'mediaList' => $mediaList,
        ]);
    }

    /**
     * Lưu bài viết mới vào cơ sở dữ liệu.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content_html' => ['required', 'string'],
            'featured_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'status' => ['required', 'in:published,draft'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        $now = now();
        $slug = Str::slug($validated['title']);

        // Đảm bảo tính duy nhất của slug
        $count = DB::table('posts')->where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-'.($count + 1);
        }

        DB::table('posts')->insert([
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'],
            'content_html' => $validated['content_html'],
            'featured_media_id' => $validated['featured_media_id'] ?? null,
            'status' => $validated['status'],
            'author_id' => Auth::id(),
            'published_at' => $validated['status'] === 'published' ? $now : null,
            'meta_title' => $validated['meta_title'] ?? $validated['title'],
            'meta_description' => $validated['meta_description'] ?? Str::limit(strip_tags($validated['content_html']), 160),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Đã tạo bài viết tin tức mới thành công!');
    }

    /**
     * Giao diện chỉnh sửa bài viết.
     */
    public function edit(int $id): View
    {
        $post = DB::table('posts')->where('id', $id)->first();
        if (! $post) {
            abort(404, 'Không tìm thấy bài viết này.');
        }

        $mediaList = DB::table('media')->orderBy('created_at', 'desc')->limit(30)->get();

        return view('admin.posts.edit', [
            'post' => $post,
            'mediaList' => $mediaList,
        ]);
    }

    /**
     * Cập nhật bài viết.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content_html' => ['required', 'string'],
            'featured_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'status' => ['required', 'in:published,draft'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        $post = DB::table('posts')->where('id', $id)->first();
        if (! $post) {
            abort(404);
        }

        $now = now();
        $publishedAt = $post->published_at;
        if ($validated['status'] === 'published' && empty($publishedAt)) {
            $publishedAt = $now;
        }

        DB::table('posts')->where('id', $id)->update([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'],
            'content_html' => $validated['content_html'],
            'featured_media_id' => $validated['featured_media_id'] ?? null,
            'status' => $validated['status'],
            'published_at' => $publishedAt,
            'meta_title' => $validated['meta_title'] ?? $validated['title'],
            'meta_description' => $validated['meta_description'] ?? Str::limit(strip_tags($validated['content_html']), 160),
            'updated_at' => $now,
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Đã lưu cập nhật bài viết thành công!');
    }

    /**
     * Xóa bài viết.
     */
    public function destroy(int $id): RedirectResponse
    {
        DB::table('posts')->where('id', $id)->update([
            'deleted_at' => now(),
            'status' => 'draft',
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Đã chuyển bài viết vào thùng rác.');
    }
}
