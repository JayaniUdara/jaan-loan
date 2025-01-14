<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanCollectorsTable extends Migration
{
    public function up()
    {
        Schema::create('loan_collectors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('assigned_date'); // Date when the collector is assigned
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loan_collectors');
    }
}
