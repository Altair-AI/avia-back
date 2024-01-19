<?php

namespace App\Providers;

use App\Models\CaseBasedKnowledgeBase;
use App\Models\Document;
use App\Models\MalfunctionCauseRule;
use App\Models\MalfunctionCode;
use App\Models\Operation;
use App\Models\OperationRule;
use App\Models\Organization;
use App\Models\Project;
use App\Models\RealTimeTechnicalSystem;
use App\Models\RuleBasedKnowledgeBase;
use App\Models\TechnicalSystem;
use App\Models\User;
use App\Models\WorkSession;
use App\Policies\CaseBasedKnowledgeBasePolicy;
use App\Policies\DocumentPolicy;
use App\Policies\MalfunctionCauseRulePolicy;
use App\Policies\MalfunctionCodePolicy;
use App\Policies\OperationPolicy;
use App\Policies\OperationRulePolicy;
use App\Policies\OrganizationPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\RealTimeTechnicalSystemPolicy;
use App\Policies\RuleBasedKnowledgeBasePolicy;
use App\Policies\TechnicalSystemPolicy;
use App\Policies\UserPolicy;
use App\Policies\WorkSessionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        CaseBasedKnowledgeBase::class => CaseBasedKnowledgeBasePolicy::class,
        Document::class => DocumentPolicy::class,
        MalfunctionCauseRule::class => MalfunctionCauseRulePolicy::class,
        MalfunctionCode::class => MalfunctionCodePolicy::class,
        Operation::class => OperationPolicy::class,
        OperationRule::class => OperationRulePolicy::class,
        Organization::class => OrganizationPolicy::class,
        Project::class => ProjectPolicy::class,
        RealTimeTechnicalSystem::class => RealTimeTechnicalSystemPolicy::class,
        RuleBasedKnowledgeBase::class => RuleBasedKnowledgeBasePolicy::class,
        TechnicalSystem::class => TechnicalSystemPolicy::class,
        User::class => UserPolicy::class,
        WorkSession::class => WorkSessionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
