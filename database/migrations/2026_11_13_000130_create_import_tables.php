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
        Schema::create('import_batches', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50); // products, posts, media
            $table->string('source_url', 2000)->nullable();
            $table->string('status', 20)->default('pending'); // pending, running, completed, failed
            $table->unsignedInteger('total_items')->default(0);
            $table->unsignedInteger('processed_items')->default(0);
            $table->unsignedInteger('success_items')->default(0);
            $table->unsignedInteger('failed_items')->default(0);
            $table->unsignedInteger('review_items')->default(0);
            $table->text('error_log')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->index(['type', 'status']);
        });

        Schema::create('import_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');
            $table->string('source_url', 2000)->nullable();
            $table->string('source_identifier', 500)->nullable();
            $table->string('status', 20)->default('pending'); // pending, success, failed, review
            $table->string('target_type', 50)->nullable(); // product, post
            $table->unsignedBigInteger('target_id')->nullable();
            $table->json('source_data')->nullable();
            $table->json('errors')->nullable();
            $table->timestamps();

            $table->index(['batch_id', 'status']);
            $table->foreign('batch_id')->references('id')->on('import_batches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_items');
        Schema::dropIfExists('import_batches');
    }
};
