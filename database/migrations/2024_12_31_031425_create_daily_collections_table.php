<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyCollectionsTable extends Migration
{
    public function up()
    {
        Schema::create('daily_collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Loan Collector
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->decimal('amount_collected', 10, 2);
            $table->enum('status', ['collected', 'pending']);
            $table->text('notes')->nullable();
            $table->date('collection_date');
            $table->timestamps();
            $table->boolean('is_approved')->default(false); // Approval status
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete(); // Approver
      
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_collections');
    }
}
