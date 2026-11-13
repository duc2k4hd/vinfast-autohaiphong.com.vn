<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Consent records (GDPR/PDPA)
        Schema::create('consent_records', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50); // marketing, data_processing, contact
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('source_url', 2000)->nullable();
            $table->timestamps();
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->default('quote'); // quote, consultation, test_drive, contact
            $table->string('name', 255);
            $table->string('phone', 20)->index();
            $table->string('email', 255)->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->string('source_url', 2000)->nullable();
            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->string('status', 20)->default('new'); // new, contacted, qualified, converted, closed
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->text('message')->nullable();
            $table->unsignedBigInteger('consent_id')->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
            $table->index(['type', 'status']);
            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
            $table->foreign('variant_id')->references('id')->on('product_variants')->nullOnDelete();
            $table->foreign('consent_id')->references('id')->on('consent_records')->nullOnDelete();
        });

        Schema::create('lead_status_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id');
            $table->string('status', 20);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->timestamps();
            $table->index('lead_id');
            $table->foreign('lead_id')->references('id')->on('leads');
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('phone', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('subject', 255)->nullable();
            $table->text('message');
            $table->string('ip_address', 45)->nullable();
            $table->boolean('is_read')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('lead_status_histories');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('consent_records');
    }
};
