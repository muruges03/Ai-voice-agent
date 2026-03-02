<?php
class PlanResolverService
{
    public function getActivePlan()
    {
        $tenant = tenant();

        return cache()->remember(
            "tenant:{$tenant->id}:plan",
            now()->addMinutes(5),
            function () use ($tenant) {
                return $tenant->subscription->plan;
            }
        );
    }
}