<?php

namespace App\Providers;

use App\Models\Document;
use App\Models\Operation;
use App\Models\Organization;
use App\Models\Project;
use App\Models\TechnicalSystem;
use App\Models\User;
use App\Policies\DocumentPolicy;
use App\Policies\OperationPolicy;
use App\Policies\OrganizationPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\TechnicalSystemPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Document::class => DocumentPolicy::class,
        Organization::class => OrganizationPolicy::class,
        Operation::class => OperationPolicy::class,
        Project::class => ProjectPolicy::class,
        TechnicalSystem::class => TechnicalSystemPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
