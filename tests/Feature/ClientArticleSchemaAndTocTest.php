<?php

namespace Tests\Feature;

use Database\Seeders\InitialAdminUserSeeder;
use Database\Seeders\InitialPostsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ClientArticleSchemaAndTocTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(InitialAdminUserSeeder::class);
        $this->seed(InitialPostsSeeder::class);
    }

    public function test_post_detail_renders_article_schema_and_toc_container(): void
    {
        $post = DB::table('posts')->where('status', 'published')->first();
        $this->assertNotNull($post);

        $response = $this->get(url('/chuyen-muc/tin-tuc/'.$post->slug));

        $response->assertStatus(200);
        $response->assertSee('NewsArticle');
        $response->assertSee('BreadcrumbList');
        $response->assertSee('vf-post-toc-container');
        $response->assertSee('MỤC LỤC BÀI VIẾT');
    }
}
