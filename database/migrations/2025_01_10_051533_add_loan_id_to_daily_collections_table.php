<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoanIdToDailyCollectionsTable extends Migration
{
    public function up()
    {
        Schema::table('daily_collections', function (Blueprint $table) {
            $table->foreignId('loan_id')->after('id')->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('daily_collections', function (Blueprint $table) {
            $table->dropForeign(['loan_id']);
            $table->dropColumn('loan_id');
        });
    }
}
