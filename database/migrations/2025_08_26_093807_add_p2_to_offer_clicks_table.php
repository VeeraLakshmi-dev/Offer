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
        Schema::table('offer_clicks', function (Blueprint $table) {
            $table->string('p2')->nullable();
            $table->string('payouts')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offer_clicks', function (Blueprint $table) {
            $table->dropColumn('p2');
            $table->dropColumn('payouts');
        });
    }
};
