<?php

use Domain\Customers\Models\Customer;
use Domain\Loans\Models\Loan;
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
        Schema::create('repayments', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->foreignIdFor(Customer::class, 'customer_id');
            $table->foreignIdFor(Loan::class, 'loan_id');
            $table->unsignedBigInteger('amount_paid');
            $table->date('paid_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repayments');
    }
};
