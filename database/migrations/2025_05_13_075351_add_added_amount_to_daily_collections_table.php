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
        Schema::table('daily_collections', function (Blueprint $table) {
            $table->decimal('added_amount', 10, 2)->nullable()->after('amount_collected');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_collections', function (Blueprint $table) {
            $table->dropColumn('added_amount');
        });
    }
};
