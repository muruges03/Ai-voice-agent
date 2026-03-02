<?php

use App\Models\Tenant\UsageCounter;

class UsageQuotaService
{
    public function getCurrentMonthUsage()
    {
        return UsageCounter::firstOrCreate([
            'month' => now()->format('Y-m')
        ]);
    }

    public function canUseMinutes(int $seconds): bool
    {
        $plan = app(PlanResolverService::class)->getActivePlan();
        $usage = $this->getCurrentMonthUsage();

        return ($usage->total_minutes_used + ceil($seconds / 60))
                <= $plan->monthly_minutes;
    }

    public function incrementMinutes(int $seconds)
    {
        $usage = $this->getCurrentMonthUsage();

        $usage->increment('total_minutes_used', ceil($seconds / 60));
    }
}