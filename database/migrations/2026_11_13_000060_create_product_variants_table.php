<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('sku', 100)->nullable()->unique();
            $table->string('name', 255); // Tên phiên bản: Standard, Plus, Eco...
            $table->string('color_code', 20)->nullable(); // hex #FFFFFF
            $table->string('color_name', 100)->nullable();
            $table->unsignedBigInteger('regular_price')->nullable(); // VND
            $table->unsignedBigInteger('sale_price')->nullable(); // VND
            $table->boolean('is_available')->default(true); // thay vì stock_quantity cho xe
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->unsignedBigInteger('thumbnail_media_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['product_id', 'is_active', 'sort_order']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('thumbnail_media_id')->references('id')->on('media')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
