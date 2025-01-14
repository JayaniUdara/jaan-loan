<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Full name of the customer
            $table->string('contact_number')->unique(); // Unique contact number
            $table->string('email')->nullable(); // Optional email
            $table->text('address')->nullable(); // Physical address
            $table->date('date_of_birth')->nullable(); // Date of birth
            $table->string('national_id')->nullable()->unique(); // National ID or equivalent
            $table->string('occupation')->nullable(); // Customer's occupation
            $table->decimal('monthly_income', 10, 2)->nullable(); // Monthly income
            $table->text('profile_photo_path')->nullable(); // Path to profile photo
            $table->timestamps();
            $table->boolean('is_approved')->default(false); // Approval status
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete(); // Approver
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
