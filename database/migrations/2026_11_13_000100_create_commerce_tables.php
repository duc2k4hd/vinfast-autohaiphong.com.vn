<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Carts
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 100)->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->timestamps();
            $table->index(['session_id', 'updated_at']);
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->unsignedBigInteger('unit_price'); // snapshot giá tại thời điểm thêm
            $table->timestamps();
            $table->unique(['cart_id', 'product_id', 'variant_id']);
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('variant_id')->references('id')->on('product_variants')->nullOnDelete();
        });

        // Orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 30)->unique();
            $table->string('customer_name', 255);
            $table->string('customer_phone', 20);
            $table->string('customer_email', 255)->nullable();
            $table->text('customer_note')->nullable();
            $table->unsignedBigInteger('subtotal'); // VND
            $table->unsignedBigInteger('discount_total')->default(0); // VND
            $table->unsignedBigInteger('total'); // VND
            $table->char('currency', 3)->default('VND');
            $table->string('payment_method', 20)->default('cash'); // cash ONLY
            $table->string('payment_status', 20)->default('unpaid'); // unpaid, paid, refunded
            $table->string('order_status', 30)->default('pending'); // pending, confirmed, processing, completed, cancelled
            $table->char('idempotency_key', 64)->nullable()->unique(); // chống đặt trùng
            $table->unsignedBigInteger('consent_id')->nullable();
            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->timestamps();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->index(['order_status', 'created_at']);
            $table->index(['payment_status', 'order_status']);
            $table->index('customer_phone');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id')->nullable(); // nullable để giữ lịch sử khi xóa product
            $table->unsignedBigInteger('variant_id')->nullable();
            // Snapshot — không được thay đổi sau khi tạo
            $table->string('product_name', 255);
            $table->string('product_sku', 100)->nullable();
            $table->string('variant_name', 255)->nullable();
            $table->string('color_name', 100)->nullable();
            $table->unsignedBigInteger('unit_price'); // VND snapshot
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->unsignedBigInteger('line_total'); // VND snapshot
            $table->timestamps();
            $table->index('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            // Nullable FK để giữ lịch sử
            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
            $table->foreign('variant_id')->references('id')->on('product_variants')->nullOnDelete();
        });

        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('status', 30);
            $table->string('payment_status', 20)->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->timestamps();
            $table->index('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
        });

        Schema::create('payment_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('amount'); // VND
            $table->string('method', 20)->default('cash');
            $table->string('status', 20)->default('confirmed');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('confirmed_by')->nullable(); // admin user id
            $table->timestamp('received_at')->nullable();
            $table->timestamps();
            $table->index('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_records');
        Schema::dropIfExists('order_status_histories');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};
