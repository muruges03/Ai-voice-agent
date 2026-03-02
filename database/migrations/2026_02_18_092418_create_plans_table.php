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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            // Identification
            $table->string('name');
            $table->string('slug')->unique(); // starter, growth, business

            // Stripe Integration
            $table->string('stripe_price_id')->nullable();
            $table->string('stripe_product_id')->nullable();

            // Billing
            $table->decimal('price_monthly', 10, 2)->default(0);
            $table->decimal('price_yearly', 10, 2)->nullable();
            $table->integer('trial_days')->default(0);

            // Usage Limits
            $table->integer('max_agents')->default(1);
            $table->integer('max_users')->default(1);
            $table->integer('monthly_minutes')->default(0);
            $table->integer('max_concurrent_calls')->default(1);

            // Feature Flags
            $table->boolean('allow_call_transfer')->default(false);
            $table->boolean('allow_live_monitoring')->default(false);
            $table->boolean('allow_crm_integrations')->default(false);
            $table->boolean('allow_ab_testing')->default(false);
            $table->boolean('allow_webhooks')->default(false);
            $table->boolean('allow_custom_voices')->default(false);

            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_public')->default(true); // visible on pricing page
            $table->integer('sort_order')->default(0);

            // JSON for future-proofing
            $table->json('metadata')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
