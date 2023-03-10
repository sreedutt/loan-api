<?php

use Domain\Customers\Models\Customer;
use Domain\Loans\Enums\LoanStatus;
use Domain\Loans\Enums\RepaymentFrequency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->foreignIdFor(Customer::class, 'customer_id');
            $table->unsignedMediumInteger('repayment_term');
            $table->enum('repayment_frequency', RepaymentFrequency::getValues());
            $table->unsignedBigInteger('amount');
            $table->float('interest_rate', 4, 2)->nullable();
            $table->enum('status', LoanStatus::getValues())->default(LoanStatus::PENDING->value); //ADD INDEX
            $table->dateTime('approved_at')->nullable();
            $table->foreignIdFor(Customer::class, 'approved_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
