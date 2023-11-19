<?php

namespace App\Providers;

use App\Models\Document;
use App\Models\MalfunctionCauseRule;
use App\Models\Operation;
use App\Models\OperationRule;
use App\Models\Organization;
use App\Models\Project;
use App\Models\RuleBasedKnowledgeBase;
use App\Models\TechnicalSystem;
use App\Models\User;
use App\Policies\DocumentPolicy;
use App\Policies\MalfunctionCauseRulePolicy;
use App\Policies\OperationPolicy;
use App\Policies\OperationRulePolicy;
use App\Policies\OrganizationPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\RuleBasedKnowledgeBasePolicy;
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
        MalfunctionCauseRule::class => MalfunctionCauseRulePolicy::class,
        Operation::class => OperationPolicy::class,
        OperationRule::class => OperationRulePolicy::class,
        Organization::class => OrganizationPolicy::class,
        Project::class => ProjectPolicy::class,
        RuleBasedKnowledgeBase::class => RuleBasedKnowledgeBasePolicy::class,
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
