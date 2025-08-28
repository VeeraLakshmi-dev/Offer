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
       Schema::create('conversions', function (Blueprint $table) {
            $table->id();
            $table->string('publisher_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('click_id')->unique();
            $table->decimal('payout', 10, 2)->default(0);
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversions');
    }
};
