<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domain\Loans\Repositories\LoanRepository;
use Domain\Customers\Repositories\CustomerRepository;
use Domain\Loans\Repositories\LoanRepositoryInterface;
use Domain\Customers\Repositories\CustomerRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(LoanRepositoryInterface::class, LoanRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
