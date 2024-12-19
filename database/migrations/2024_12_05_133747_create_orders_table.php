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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn')->nullable();
            $table->string('email')->nullable();
            $table->double('final_price', 10, 2)->default(0.0);
            $table->double('cost_price' , 10, 2)->default(0.0);
            $table->json('user_agent')->nullable();
            $table->string('iccid')->nullable();
            $table->string('promocode_value')->nullable();
            $table->string('transaction_id')->nullable();
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->unsignedBigInteger('source_id')->nullable();
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');
            $table->unsignedBigInteger('status')->nullable();
            $table->foreign('status')->references('id')->on('lookups')->onDelete('cascade');
            $table->unsignedBigInteger('promo_code_id')->nullable();
            $table->foreign('promo_code_id')->references('id')->on('promo_codes')->onDelete('cascade');
            $table->unsignedBigInteger('item_source_id')->nullable();
            $table->foreign('item_source_id')->references('id')->on('item_sources')->onDelete('cascade');
            $table->unsignedBigInteger('share_id')->nullable();
            $table->foreign('share_id')->references('id')->on('users')->onDelete('cascade');
            $table->longText('order_data')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
