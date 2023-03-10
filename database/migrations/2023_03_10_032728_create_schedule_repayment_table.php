<?php

use Domain\Loans\Enums\RepaymentStatus;
use Domain\Loans\Models\Loan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedule_repayments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Loan::class, 'loan_id');
            $table->unsignedBigInteger('amount_to_be_paid');
            $table->date('repayment_date');
            $table->enum('status', RepaymentStatus::getValues())->default(RepaymentStatus::PENDING->value);
            $table->date('paid_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_repayment');
    }
};
