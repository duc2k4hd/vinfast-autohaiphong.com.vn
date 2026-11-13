<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\InitialAdminUserSeeder;
use Database\Seeders\InitialPostsSeeder;
use Database\Seeders\InitialSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminPostAndMediaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(InitialSettingsSeeder::class);
        $this->seed(InitialAdminUserSeeder::class);
        $this->seed(InitialPostsSeeder::class);
    }

    public function test_admin_can_view_and_create_post(): void
    {
        $admin = User::first();

        // 1. Xem danh sách
        $indexResponse = $this->actingAs($admin)->get('/admin/posts');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('TẤT CẢ BÀI VIẾT');

        // 2. Tạo bài viết mới
        $createResponse = $this->actingAs($admin)->post('/admin/posts', [
            'title' => 'Chương Trình Tri Ân Khách Hàng Hải Phòng 2026',
            'excerpt' => 'Tóm tắt bài viết tri ân...',
            'content_html' => '<p>Nội dung chi tiết chương trình tri ân...</p>',
            'status' => 'published',
        ]);

        $createResponse->assertRedirect('/admin/posts');

        $this->assertDatabaseHas('posts', [
            'title' => 'Chương Trình Tri Ân Khách Hàng Hải Phòng 2026',
            'status' => 'published',
        ]);
    }

    public function test_admin_can_update_and_delete_post(): void
    {
        $admin = User::first();
        $post = DB::table('posts')->first();

        // Sửa bài viết
        $updateResponse = $this->actingAs($admin)->put('/admin/posts/'.$post->id, [
            'title' => 'Tiêu Đề Đã Được Chỉnh Sửa',
            'excerpt' => 'Tóm tắt mới',
            'content_html' => '<p>Nội dung mới cập nhật</p>',
            'status' => 'published',
        ]);

        $updateResponse->assertRedirect('/admin/posts');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Tiêu Đề Đã Được Chỉnh Sửa',
        ]);

        // Xóa bài viết
        $deleteResponse = $this->actingAs($admin)->delete('/admin/posts/'.$post->id);
        $deleteResponse->assertRedirect('/admin/posts');

        $this->assertNotNull(DB::table('posts')->where('id', $post->id)->value('deleted_at'));
    }

    public function test_admin_can_view_media_library_and_upload(): void
    {
        $admin = User::first();

        // Xem thư viện
        $indexResponse = $this->actingAs($admin)->get('/admin/media');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('QUẢN LÝ THƯ VIỆN MEDIA');

        // Upload file ảnh giả lập
        $fakeFile = UploadedFile::fake()->image('test-banner.webp', 800, 400);

        $uploadResponse = $this->actingAs($admin)->post('/admin/media', [
            'file' => $fakeFile,
            'folder' => 'banners',
            'alt_text' => 'Banner kiểm thử',
        ]);

        $uploadResponse->assertSessionHas('success');

        $this->assertDatabaseHas('media', [
            'alt_text' => 'Banner kiểm thử',
        ]);
    }
}
