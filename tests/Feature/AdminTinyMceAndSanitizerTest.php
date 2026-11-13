<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Shared\HtmlSanitizer;
use Database\Seeders\InitialAdminUserSeeder;
use Database\Seeders\InitialCarsSeeder;
use Database\Seeders\InitialPostsSeeder;
use Database\Seeders\InitialSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTinyMceAndSanitizerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(InitialSettingsSeeder::class);
        $this->seed(InitialCarsSeeder::class);
        $this->seed(InitialPostsSeeder::class);
        $this->seed(InitialAdminUserSeeder::class);

        $this->admin = User::where('email', 'admin@vinfast-autohaiphong.com.vn')->first();
    }

    /**
     * Kiểm tra cấu hình TinyMCE API key thông qua config.
     */
    public function test_tinymce_key_is_configured_via_services(): void
    {
        $key = config('services.tinymce.key');
        $this->assertNotEmpty($key, 'TinyMCE API key không được để trống trong config services.');
    }

    /**
     * Kiểm tra HtmlSanitizer làm sạch các thẻ và thuộc tính độc hại.
     */
    public function test_html_sanitizer_removes_dangerous_tags_and_attributes(): void
    {
        $dirty = '<h2>Tiêu đề bài viết</h2><p>Nội dung an toàn</p><script>alert("xss")</script><iframe src="https://evil.com"></iframe><a href="javascript:steal()" onclick="hack()">Link</a><img src="pic.jpg" onerror="exploit()">';
        $cleaned = HtmlSanitizer::clean($dirty);

        $this->assertStringContainsString('<h2>Tiêu đề bài viết</h2>', $cleaned);
        $this->assertStringContainsString('<p>Nội dung an toàn</p>', $cleaned);
        $this->assertStringNotContainsString('<script', $cleaned);
        $this->assertStringNotContainsString('<iframe', $cleaned);
        $this->assertStringNotContainsString('onclick', $cleaned);
        $this->assertStringNotContainsString('onerror', $cleaned);
        $this->assertStringNotContainsString('javascript:', $cleaned);
    }

    /**
     * Kiểm tra khi cập nhật bài viết admin, nội dung HTML được sanitize trước khi lưu.
     */
    public function test_admin_post_content_is_sanitized_on_update(): void
    {
        $post = DB::table('posts')->first();

        $payload = [
            'title' => 'Bài viết thử nghiệm bảo mật',
            'excerpt' => 'Tóm tắt bài viết',
            'content_html' => '<p>Đoạn văn hợp lệ</p><script>evil()</script><div onload="bad()">Khối an toàn</div>',
            'status' => 'published',
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.posts.update', $post->id), $payload);

        $response->assertRedirect(route('admin.posts.index'));

        $updatedPost = DB::table('posts')->where('id', $post->id)->first();
        $this->assertStringContainsString('<p>Đoạn văn hợp lệ</p>', $updatedPost->content_html);
        $this->assertStringNotContainsString('<script', $updatedPost->content_html);
        $this->assertStringNotContainsString('onload', $updatedPost->content_html);
    }

    /**
     * Kiểm tra endpoint upload ảnh AJAX của TinyMCE trả về JSON location hợp lệ.
     */
    public function test_tinymce_ajax_image_upload_returns_valid_location_json(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test_tinymce_upload.jpg', 800, 600);

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.media.store'), [
                'file' => $file,
                'folder' => 'posts',
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['location', 'media_id', 'path']);
        $this->assertStringContainsString('clients/assets/images/posts/', $response->json('location'));
    }
}
