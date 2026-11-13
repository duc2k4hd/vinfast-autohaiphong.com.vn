<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable()->index();
            $table->string('sku', 100)->nullable()->unique();
            $table->string('name', 255);
            $table->string('slug', 191)->unique();
            $table->text('short_description')->nullable();
            $table->longText('description_html')->nullable();
            $table->unsignedBigInteger('regular_price')->nullable(); // VND
            $table->unsignedBigInteger('sale_price')->nullable(); // VND
            $table->boolean('price_on_request')->default(false);
            $table->string('status', 20)->default('draft'); // draft, published, archived
            $table->boolean('featured')->default(false)->index();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->unsignedBigInteger('thumbnail_media_id')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'published_at']);
            $table->index(['category_id', 'status', 'sort_order']);
            $table->index(['featured', 'status']);
            $table->foreign('category_id')->references('id')->on('product_categories')->nullOnDelete();
            $table->foreign('thumbnail_media_id')->references('id')->on('media')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
