<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_spec_highlights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('value', 255)->comment('Số hoặc giá trị nổi bật (VD: 215, 36, 7 năm hoặc 160.000km)');
            $table->string('unit', 255)->nullable()->comment('Đơn vị (VD: km/1 lần sạc (NEDC), phút)');
            $table->string('subtitle', 255)->nullable()->comment('Phụ chú nhỏ (VD: Tùy điều kiện nào đến trước)');
            $table->string('label', 255)->comment('Tên nhãn (VD: Quãng đường di chuyển, Sạc nhanh, Bảo hành)');
            $table->unsignedSmallInteger('sort_order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['product_id', 'is_active', 'sort_order'], 'psh_product_active_sort_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_spec_highlights');
    }
};
