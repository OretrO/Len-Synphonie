<?php

namespace App\Providers;

use App\Models\Arrangement;
use App\Models\Partition;
use App\Policies\ArrangementPolicy;
use App\Policies\PartitionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Partition::class   => PartitionPolicy::class,
        Arrangement::class => ArrangementPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
