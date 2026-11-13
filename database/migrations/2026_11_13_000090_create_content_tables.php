<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pages (trang tĩnh)
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 500);
            $table->string('slug', 255)->unique();
            $table->longText('content_html')->nullable();
            $table->string('template', 50)->default('default');
            $table->string('status', 20)->default('draft');
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->unsignedBigInteger('featured_media_id')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'slug']);
            $table->foreign('featured_media_id')->references('id')->on('media')->nullOnDelete();
        });

        // Banners
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150); // tên nội bộ
            $table->string('position', 50)->default('home_hero'); // home_hero, home_promo
            $table->string('title', 500)->nullable();
            $table->text('subtitle')->nullable();
            $table->string('cta_text', 100)->nullable();
            $table->string('cta_url', 2000)->nullable();
            $table->unsignedBigInteger('desktop_media_id')->nullable();
            $table->unsignedBigInteger('mobile_media_id')->nullable();
            $table->unsignedBigInteger('link_product_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
            $table->index(['position', 'is_active', 'sort_order']);
            $table->foreign('desktop_media_id')->references('id')->on('media')->nullOnDelete();
            $table->foreign('mobile_media_id')->references('id')->on('media')->nullOnDelete();
        });

        // Menus
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // header, footer, mobile
            $table->string('slug', 100)->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('label', 150);
            $table->string('url', 2000)->nullable();
            $table->string('route_name', 150)->nullable();
            $table->string('target', 10)->default('_self'); // _self, _blank
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index(['menu_id', 'parent_id', 'sort_order']);
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('menu_items')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('pages');
    }
};
