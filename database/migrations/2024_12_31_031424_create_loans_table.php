<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            // Foreign key for the customer
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');

            // Loan details
            $table->decimal('amount', 10, 2); // Total loan amount
            $table->date('loan_approved_date')->nullable(); // Loan start date
            $table->date('loan_end_date')->nullable(); // Loan end date

            $table->decimal('outstanding_balance', 10, 2); // Remaining balance
            $table->float('interest_rate'); // Interest rate as a percentage
            $table->integer('installment_duration'); // installment_duration in days
            $table->integer('total_installments'); // total_installments
            $table->integer('remaining_installments'); // total_installments
            $table->enum('status', ['pending', 'approved'])->default('pending'); // Loan status

            // Approval details
            $table->boolean('is_approved')->default(false); // Approval status
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete(); // Approved by

            $table->timestamps();
        });

        // Create the guarantors table
        Schema::create('guarantors', function (Blueprint $table) {
            $table->id();

            // Link to the loan
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');

            // Guarantor details
            $table->string('name');
            $table->string('contact');
            $table->string('address');
            $table->string('national_id')->nullable(); // National ID
            $table->string('relationship')->nullable(); // Relationship to the borrower
            $table->date('date_of_birth')->nullable(); // Date of birth
            $table->string('occupation')->nullable(); // Occupation
            $table->decimal('annual_income', 10, 2)->nullable(); // Annual income
            $table->string('additional_notes')->nullable(); // Any additional notes about the guarantor

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guarantors');
        Schema::dropIfExists('loans');
    }
}
