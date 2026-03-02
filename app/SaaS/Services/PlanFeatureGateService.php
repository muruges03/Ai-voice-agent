<?php

use App\Models\Agent;
use App\Models\User;

class PlanFeatureGateService
{
    protected $plan;

    public function __construct()
    {
        $this->plan = app(PlanResolverService::class)->getActivePlan();
    }

    public function checkAgentLimit()
    {
        if (Agent::count() >= $this->plan->max_agents) {
            abort(403, 'Agent limit exceeded');
        }
    }

    public function checkUserLimit()
    {
        if (User::count() >= $this->plan->max_users) {
            abort(403, 'User limit exceeded');
        }
    }

    public function checkFeature(string $feature)
    {
        if (! $this->plan->{$feature}) {
            abort(403, 'Feature not allowed on your plan');
        }
    }
}