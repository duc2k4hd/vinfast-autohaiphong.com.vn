<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Nhóm thông số (ví dụ: Hiệu suất, Pin, Kích thước)
        Schema::create('product_specification_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Các thông số kỹ thuật của từng sản phẩm
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('group_id')->nullable()->index();
            $table->string('label', 150); // Tên thông số: Quãng đường, Dung lượng pin...
            $table->string('value', 500); // Giá trị: 300 km, 59 kWh...
            $table->string('unit', 50)->nullable(); // km, kWh, kW...
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index(['product_id', 'group_id', 'sort_order']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('product_specification_groups')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_specifications');
        Schema::dropIfExists('product_specification_groups');
    }
};
