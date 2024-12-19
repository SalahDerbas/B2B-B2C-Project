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
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('promo_code')->nullable();
            $table->string('description')->nullable();
            $table->datetime('from_date')->nullable();
            $table->datetime('to_date')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id')->references('id')->on('lookups')->onDelete('cascade');
            $table->integer('limit')->nullable();
            $table->integer('user_limit')->nullable();
            $table->integer('counter')->default(0);
            $table->double('amount', 10, 2)->default(0.0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
