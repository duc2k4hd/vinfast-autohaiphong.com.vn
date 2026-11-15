<?php

namespace Tests\Feature;

use Database\Seeders\InitialCarsSeeder;
use Database\Seeders\InitialPostsSeeder;
use Database\Seeders\InitialSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PostDetailViewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        $this->seed(InitialSettingsSeeder::class);
        $this->seed(InitialCarsSeeder::class);
        $this->seed(InitialPostsSeeder::class);
    }

    public function test_post_detail_renders_cloudzone_style_layout_with_sidebar_and_content(): void
    {
        $slug = 'vinfast-vf-3-xe-dien-do-thi-hai-phong';
        $response = $this->get('/blog/'.$slug);

        $response->assertOk();

        // 1. Kiểm tra tiêu đề và bài viết
        $response->assertSee('VinFast VF 3 — Mẫu Xe Điện Đô Thị Gây Sốt');
        $response->assertSee('class="post-title"', false);
        $response->assertSee('class="post-content"', false);

        // 2. Kiểm tra thanh Breadcrumb & Meta
        $response->assertSee('Tin Tức');
        $response->assertSee('Ban Biên Tập VinFast Hải Phòng');
        $response->assertSee('phút đọc');

        // 3. Kiểm tra các nút chia sẻ mạng xã hội
        $response->assertSee('post-share-fb', false);
        $response->assertSee('post-share-zalo', false);
        $response->assertSee('post-share-copy', false);

        // 4. Kiểm tra Mục Lục Bài Viết (TOC)
        $response->assertSee('vf-post-toc-container', false);
        $response->assertSee('MỤC LỤC BÀI VIẾT');

        // 5. Kiểm tra Sidebar Sticky (Tin mới nhất, Bảng giá xe, Đại lý)
        $response->assertSee('post-sidebar-sticky', false);
        $response->assertSee('TIN MỚI NHẤT');
        $response->assertSee('BẢNG GIÁ XE VINFAST');
        $response->assertSee('ĐẠI LÝ VINFAST HẢI PHÒNG');
        $response->assertSee('0988 302 882');

        // 6. Kiểm tra khối bài viết liên quan
        $response->assertSee('BÀI VIẾT LIÊN QUAN');

        // 7. Kiểm tra SEO Schema JSON-LD
        $response->assertSee('"@type": "NewsArticle"', false);
        $response->assertSee('"@type": "BreadcrumbList"', false);
    }

    public function test_post_detail_uses_cache_for_high_performance(): void
    {
        $slug = 'vinfast-vf-3-xe-dien-do-thi-hai-phong';
        $cacheKey = 'post_detail_v2_'.md5($slug);

        Cache::forget($cacheKey);
        $this->assertFalse(Cache::has($cacheKey));

        // Lần truy cập 1: Tải vào cache
        $this->get('/blog/'.$slug)->assertOk();
        $this->assertTrue(Cache::has($cacheKey));

        // Lần truy cập 2: Phục vụ trực tiếp từ cache mà không cần truy vấn lại
        $cachedData = Cache::get($cacheKey);
        $this->assertIsArray($cachedData);
        $this->assertArrayHasKey('post', $cachedData);
        $this->assertArrayHasKey('relatedPosts', $cachedData);
        $this->assertArrayHasKey('latestPosts', $cachedData);
        $this->assertArrayHasKey('featuredCars', $cachedData);

        $this->get('/blog/'.$slug)->assertOk();
    }

    public function test_post_detail_works_with_database_cache_store(): void
    {
        config(['cache.default' => 'database']);
        $slug = 'huong-dan-su-dung-tram-sac-vinfast-hai-phong';

        // Lần 1: Lưu vào database cache
        $response1 = $this->get('/blog/'.$slug);
        $response1->assertOk();

        // Lần 2: Đọc trực tiếp từ database cache và render view thành công
        $response2 = $this->get('/blog/'.$slug);
        $response2->assertOk();
        $response2->assertSee('Cẩm Nang Hướng Dẫn Sử Dụng Trạm Sạc Xe Điện VinFast Tại Hải Phòng');
    }
}
