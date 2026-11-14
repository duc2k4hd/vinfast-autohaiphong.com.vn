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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('video_media_id')->nullable()->after('thumbnail_media_id');
            $table->string('video_path', 500)->nullable()->after('video_media_id');
            $table->unsignedBigInteger('video_poster_media_id')->nullable()->after('video_path');
            $table->string('video_poster_path', 500)->nullable()->after('video_poster_media_id');
            $table->string('video_title', 255)->nullable()->after('video_poster_path');

            $table->index('video_media_id');
            $table->index('video_poster_media_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['video_media_id']);
            $table->dropIndex(['video_poster_media_id']);
            $table->dropColumn([
                'video_media_id',
                'video_path',
                'video_poster_media_id',
                'video_poster_path',
                'video_title',
            ]);
        });
    }
};
