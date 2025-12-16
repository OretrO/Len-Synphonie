<?php

namespace App\Providers;

use App\Models\Arrangement;
use App\Models\Partition;
use App\Models\User;
use App\Policies\ArrangementPolicy;
use App\Policies\PartitionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('manage-users', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
