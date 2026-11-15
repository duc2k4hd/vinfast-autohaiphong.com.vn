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
        if (Schema::hasTable('products') && ! Schema::hasColumn('products', 'show_in_menu')) {
            Schema::table('products', function (Blueprint $table) {
                $table->boolean('show_in_menu')->default(true)->after('sort_order');
            });
        }

        if (Schema::hasTable('menu_items')) {
            Schema::table('menu_items', function (Blueprint $table) {
                if (! Schema::hasColumn('menu_items', 'image_media_id')) {
                    $table->unsignedBigInteger('image_media_id')->nullable()->after('route_name');
                    $table->foreign('image_media_id')->references('id')->on('media')->nullOnDelete();
                }
                if (! Schema::hasColumn('menu_items', 'badge')) {
                    $table->string('badge', 100)->nullable()->after('label');
                }
                if (! Schema::hasColumn('menu_items', 'description')) {
                    $table->string('description', 255)->nullable()->after('badge');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'show_in_menu')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('show_in_menu');
            });
        }

        if (Schema::hasTable('menu_items')) {
            Schema::table('menu_items', function (Blueprint $table) {
                if (Schema::hasColumn('menu_items', 'image_media_id')) {
                    $table->dropForeign(['image_media_id']);
                    $table->dropColumn('image_media_id');
                }
                if (Schema::hasColumn('menu_items', 'badge')) {
                    $table->dropColumn('badge');
                }
                if (Schema::hasColumn('menu_items', 'description')) {
                    $table->dropColumn('description');
                }
            });
        }
    }
};
