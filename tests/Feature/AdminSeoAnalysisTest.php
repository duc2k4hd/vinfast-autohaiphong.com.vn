<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Shared\SeoService;
use Database\Seeders\InitialAdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSeoAnalysisTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(InitialAdminUserSeeder::class);
        $this->admin = User::where('email', 'admin@vinfast-autohaiphong.com.vn')->first();
    }

    public function test_seo_service_evaluates_score_accurately(): void
    {
        $title = 'Đánh Giá Xe VinFast VF 3 Chi Tiết Nhất';
        $metaTitle = 'Đánh Giá Xe VinFast VF 3 Chi Tiết Nhất Tại Hải Phòng';
        $metaDesc = 'Tìm hiểu chi tiết thông số, giá bán và chính sách ưu đãi của dòng xe điện VinFast VF 3 mới nhất tại đại lý chính hãng Hải Phòng.';
        $content = str_repeat('VinFast VF 3 là dòng xe điện mini thông minh được ưa chuộng hàng đầu. ', 35);
        $keyword = 'VinFast VF 3';

        $analysis = SeoService::evaluateSeoScore($title, $metaTitle, $metaDesc, $content, $keyword);

        $this->assertIsArray($analysis);
        $this->assertGreaterThanOrEqual(80, $analysis['score']);
        $this->assertEquals('tốt', $analysis['status']);
        $this->assertGreaterThan(300, $analysis['word_count']);
        $this->assertNotEmpty($analysis['good_points']);
    }

    public function test_seo_service_generates_unique_slug(): void
    {
        $slug = SeoService::generateUniqueSlug('VinFast VF 3 Giá Lăn Bánh', 'posts');
        $this->assertEquals('vinfast-vf-3-gia-lan-banh', $slug);
    }

    public function test_admin_can_call_seo_analyze_endpoint(): void
    {
        $payload = [
            'title' => 'Bảng Giá Xe Ô Tô Điện VinFast Mới Nhất',
            'meta_title' => 'Bảng Giá Xe Ô Tô Điện VinFast Mới Nhất 2026',
            'meta_description' => 'Cập nhật bảng giá xe ô tô điện VinFast mới nhất tại Hải Phòng cùng chính sách ưu đãi và trả góp hấp dẫn.',
            'content' => str_repeat('Bảng giá xe ô tô điện VinFast được áp dụng trên toàn quốc. ', 30),
            'focus_keyword' => 'xe ô tô điện VinFast',
        ];

        $response = $this->actingAs($this->admin)->postJson(route('admin.seo.analyze'), $payload);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'score',
                'status',
                'word_count',
                'reading_time',
                'keyword_density',
                'issues',
                'good_points',
            ],
        ]);
    }
}

