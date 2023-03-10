<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domain\Loans\Repositories\LoanRepository;
use Domain\Loans\Repositories\RepaymentRepository;
use Domain\Customers\Repositories\CustomerRepository;
use Domain\Loans\Repositories\LoanRepositoryInterface;
use Domain\Loans\Repositories\ScheduleRepaymentRepository;
use Domain\Loans\Repositories\RepaymentRepositoryInterface;
use Domain\Customers\Repositories\CustomerRepositoryInterface;
use Domain\Loans\Repositories\ScheduleRepaymentRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(LoanRepositoryInterface::class, LoanRepository::class);
        $this->app->bind(ScheduleRepaymentRepositoryInterface::class, ScheduleRepaymentRepository::class);
        $this->app->bind(RepaymentRepositoryInterface::class, RepaymentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
