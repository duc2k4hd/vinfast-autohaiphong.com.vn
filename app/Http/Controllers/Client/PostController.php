<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Danh sách tin tức, bài viết.
     */
    public function index(Request $request): View
    {
        if ($request->route('page')) {
            $request->merge(['page' => (int) $request->route('page')]);
        }

        $posts = DB::table('posts')
            ->leftJoin('media', 'posts.featured_media_id', '=', 'media.id')
            ->where('posts.status', 'published')
            ->where(function ($q) {
                $q->whereNull('posts.published_at')
                    ->orWhere('posts.published_at', '<=', now());
            })
            ->select([
                'posts.id',
                'posts.title',
                'posts.slug',
                'posts.excerpt',
                'posts.published_at',
                'media.path as thumbnail_path',
            ])
            ->orderBy('posts.published_at', 'desc')
            ->paginate(9);

        return view('clients.pages.posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Chi tiết một bài viết.
     */
    public function show(string $slug): View
    {
        $post = DB::table('posts')
            ->leftJoin('media', 'posts.featured_media_id', '=', 'media.id')
            ->where('posts.slug', $slug)
            ->where('posts.status', 'published')
            ->select([
                'posts.*',
                'media.path as thumbnail_path',
            ])
            ->first();

        if (! $post) {
            abort(404, 'Bài viết bạn đang tìm không tồn tại hoặc đã được gỡ bỏ.');
        }

        $relatedPosts = DB::table('posts')
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('clients.pages.posts.show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
