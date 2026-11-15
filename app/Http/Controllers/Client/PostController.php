<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Danh sách tin tức, bài viết (hỗ trợ lọc theo danh mục qua query ?category=).
     */
    public function index(Request $request): View
    {
        if ($request->route('page')) {
            $request->merge(['page' => (int) $request->route('page')]);
        }

        $categorySlug = $request->query('category');

        $query = DB::table('posts')
            ->leftJoin('media', 'posts.featured_media_id', '=', 'media.id')
            ->leftJoin('post_category_relations as pcr_primary', function ($join) {
                $join->on('posts.id', '=', 'pcr_primary.post_id')
                    ->where('pcr_primary.is_primary', true);
            })
            ->leftJoin('post_categories as cat_primary', 'pcr_primary.post_category_id', '=', 'cat_primary.id')
            ->where('posts.status', 'published')
            ->where(function ($q) {
                $q->whereNull('posts.published_at')
                    ->orWhere('posts.published_at', '<=', now());
            })
            ->whereNull('posts.deleted_at')
            ->select([
                'posts.id',
                'posts.title',
                'posts.slug',
                'posts.excerpt',
                'posts.published_at',
                'media.path as thumbnail_path',
                'cat_primary.name as category_name',
                'cat_primary.slug as category_slug',
            ]);

        $currentCategory = null;
        if (! empty($categorySlug)) {
            $currentCategory = DB::table('post_categories')
                ->where('slug', $categorySlug)
                ->where('status', 'active')
                ->whereNull('deleted_at')
                ->first();

            if ($currentCategory) {
                $query->join('post_category_relations as pcr_filter', 'posts.id', '=', 'pcr_filter.post_id')
                    ->where('pcr_filter.post_category_id', $currentCategory->id);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        $posts = $query->orderBy('posts.published_at', 'desc')->paginate(9)->withQueryString();

        $categories = DB::table('post_categories')
            ->where('status', 'active')
            ->whereNull('deleted_at')
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('clients.pages.posts.index', [
            'posts' => $posts,
            'categories' => $categories,
            'currentCategory' => $currentCategory,
            'selectedCategory' => $categorySlug,
        ]);
    }

    /**
     * Chi tiết một bài viết (áp dụng caching cao tầng để tối ưu tốc độ và chịu tải lớn).
     */
    public function show(string $slug): View
    {
        $cacheKey = 'post_detail_v2_'.md5($slug);

        $data = Cache::remember($cacheKey, 1800, function () use ($slug) {
            $post = DB::table('posts')
                ->leftJoin('media', 'posts.featured_media_id', '=', 'media.id')
                ->where('posts.slug', $slug)
                ->where('posts.status', 'published')
                ->whereNull('posts.deleted_at')
                ->select([
                    'posts.*',
                    'media.path as thumbnail_path',
                ])
                ->first();

            if (! $post) {
                return null;
            }

            // Danh mục chính của bài viết
            $category = DB::table('post_categories')
                ->join('post_category_relations', 'post_categories.id', '=', 'post_category_relations.post_category_id')
                ->where('post_category_relations.post_id', $post->id)
                ->select('post_categories.*')
                ->orderBy('post_category_relations.is_primary', 'desc')
                ->first();

            // Danh sách bài viết liên quan (3 bài cùng danh mục hoặc mới nhất)
            $relatedQuery = DB::table('posts')
                ->leftJoin('media', 'posts.featured_media_id', '=', 'media.id')
                ->where('posts.id', '!=', $post->id)
                ->where('posts.status', 'published')
                ->whereNull('posts.deleted_at')
                ->select([
                    'posts.id',
                    'posts.title',
                    'posts.slug',
                    'posts.excerpt',
                    'posts.published_at',
                    'media.path as thumbnail_path',
                ]);

            if ($category) {
                $relatedPosts = (clone $relatedQuery)
                    ->join('post_category_relations', 'posts.id', '=', 'post_category_relations.post_id')
                    ->where('post_category_relations.post_category_id', $category->id)
                    ->orderBy('posts.published_at', 'desc')
                    ->limit(3)
                    ->get();

                if ($relatedPosts->isEmpty()) {
                    $relatedPosts = $relatedQuery->orderBy('posts.published_at', 'desc')->limit(3)->get();
                }
            } else {
                $relatedPosts = $relatedQuery->orderBy('posts.published_at', 'desc')->limit(3)->get();
            }

            // Danh sách 5 bài viết mới nhất cho Sidebar
            $latestPosts = DB::table('posts')
                ->leftJoin('media', 'posts.featured_media_id', '=', 'media.id')
                ->where('posts.id', '!=', $post->id)
                ->where('posts.status', 'published')
                ->whereNull('posts.deleted_at')
                ->orderBy('posts.published_at', 'desc')
                ->select([
                    'posts.id',
                    'posts.title',
                    'posts.slug',
                    'posts.published_at',
                    'media.path as thumbnail_path',
                ])
                ->limit(5)
                ->get();

            // Danh sách 4 dòng xe VinFast hot cho Sidebar
            $featuredCars = DB::table('products')
                ->leftJoin('media', 'products.thumbnail_media_id', '=', 'media.id')
                ->whereIn('products.status', ['published', 'active'])
                ->whereNull('products.deleted_at')
                ->select([
                    'products.id',
                    'products.name',
                    'products.slug',
                    'products.sale_price',
                    'products.regular_price',
                    'media.path as thumbnail_path',
                ])
                ->orderBy('products.id', 'asc')
                ->limit(4)
                ->get();

            return [
                'post' => $post,
                'category' => $category,
                'relatedPosts' => $relatedPosts,
                'latestPosts' => $latestPosts,
                'featuredCars' => $featuredCars,
            ];
        });

        if (! $data) {
            abort(404, 'Bài viết bạn đang tìm không tồn tại hoặc đã được gỡ bỏ.');
        }

        return view('clients.pages.posts.show', $data);
    }
}
