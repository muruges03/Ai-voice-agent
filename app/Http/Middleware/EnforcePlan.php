<?php
class EnforcePlan
{
    public function handle($request, Closure $next, $feature = null)
    {
        $gate = app(PlanFeatureGateService::class);

        if ($feature) {
            $gate->checkFeature($feature);
        }

        return $next($request);
    }
}