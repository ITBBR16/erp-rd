<?php

namespace App\Providers;

use App\Repositories\customer\CustomerInterface;
use App\Repositories\customer\CustomerRepository;
use App\Repositories\repair\interface\RepairCaseInterface;
use App\Repositories\repair\interface\RepairCustomerInterface;
use App\Repositories\repair\repository\RepairCaseRepository;
use App\Repositories\repair\repository\RepairCustomerRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerInterface::class, CustomerRepository::class);

        // Repair
        $this->app->bind(RepairCustomerInterface::class, RepairCustomerRepository::class);
        $this->app->bind(RepairCaseInterface::class, RepairCaseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('pagination::default');
    }
}
