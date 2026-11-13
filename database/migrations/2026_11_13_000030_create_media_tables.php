<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_folders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('path', 191)->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('media_folders')->nullOnDelete();
        });

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('disk', 20)->default('public');
            $table->unsignedBigInteger('folder_id')->nullable()->index();
            $table->string('path', 1000);
            $table->string('filename', 255);
            $table->string('original_filename', 255);
            $table->string('extension', 20);
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('file_size')->default(0); // bytes
            $table->unsignedSmallInteger('width')->nullable();
            $table->unsignedSmallInteger('height')->nullable();
            $table->char('checksum_sha256', 64)->nullable()->index();
            $table->string('alt_text', 500)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('caption')->nullable();
            $table->string('source_url', 2000)->nullable();
            $table->string('source_license', 100)->nullable();
            $table->string('status', 20)->default('active'); // active, archived
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->json('metadata')->nullable(); // variants, thumbnails
            $table->timestamps();
            $table->index(['disk', 'folder_id', 'status']);
            $table->index('mime_type');
            $table->foreign('folder_id')->references('id')->on('media_folders')->nullOnDelete();
        });

        Schema::create('media_usages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_id');
            $table->string('usable_type', 100); // polymorphic
            $table->unsignedBigInteger('usable_id');
            $table->string('role', 50)->default('gallery'); // thumbnail, hero, gallery, variant, content, banner, og_image
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index(['usable_type', 'usable_id', 'role']);
            $table->index('media_id');
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_usages');
        Schema::dropIfExists('media');
        Schema::dropIfExists('media_folders');
    }
};
