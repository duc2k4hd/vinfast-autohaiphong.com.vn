<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Shared\MediaService;
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

    public function test_admin_upload_allows_up_to_10mb(): void
    {
        $admin = User::first();

        // 8MB file (8192 KB) should pass
        $largeFile = UploadedFile::fake()->create('large-car-photo.jpg', 8192, 'image/jpeg');

        $response = $this->actingAs($admin)->post('/admin/media', [
            'file' => $largeFile,
            'folder' => 'products',
            'alt_text' => 'Ảnh 8MB hợp lệ',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('media', [
            'alt_text' => 'Ảnh 8MB hợp lệ',
        ]);
    }

    public function test_admin_upload_rejects_files_over_10mb(): void
    {
        $admin = User::first();

        // 11MB file (11264 KB) should fail validation
        $oversizedFile = UploadedFile::fake()->create('oversized-photo.jpg', 11264, 'image/jpeg');

        $response = $this->actingAs($admin)
            ->from('/admin/media')
            ->post('/admin/media', [
                'file' => $oversizedFile,
                'folder' => 'products',
            ]);

        $response->assertSessionHasErrors(['file']);
        $this->assertSame(
            'Dung lượng ảnh tối đa là 10MB.',
            session('errors')->first('file')
        );
    }

    public function test_media_service_configured_for_10mb_admin_and_3mb_client(): void
    {
        $this->assertSame(10240, MediaService::getMaxUploadSizeKb(isAdmin: true, isVideo: false));
        $this->assertSame(51200, MediaService::getMaxUploadSizeKb(isAdmin: true, isVideo: true));
        $this->assertSame(3072, MediaService::getMaxUploadSizeKb(isAdmin: false));
    }

    public function test_admin_can_upload_video_up_to_50mb(): void
    {
        $admin = User::first();
        $videoFile = UploadedFile::fake()->create('car-showcase.mp4', 15000, 'video/mp4'); // 15MB

        $response = $this->actingAs($admin)
            ->post('/admin/media', [
                'file' => $videoFile,
                'folder' => 'products',
            ]);

        $response->assertRedirect('/admin/media?folder=products');
        $this->assertDatabaseHas('media', [
            'original_filename' => 'car-showcase.mp4',
            'extension' => 'mp4',
        ]);
    }

    public function test_admin_upload_rejects_videos_over_50mb(): void
    {
        $admin = User::first();
        $oversizedVideo = UploadedFile::fake()->create('huge-video.mp4', 52000, 'video/mp4'); // 52MB

        $response = $this->actingAs($admin)
            ->from('/admin/media')
            ->post('/admin/media', [
                'file' => $oversizedVideo,
                'folder' => 'products',
            ]);

        $response->assertSessionHasErrors(['file']);
        $this->assertSame(
            'Dung lượng video tối đa là 50MB.',
            session('errors')->first('file')
        );
    }
}
