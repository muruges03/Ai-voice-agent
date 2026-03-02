<?php

use App\Models\TenantSubscription;

class BillingSyncService
{
    public function sync($stripeData)
    {
        TenantSubscription::updateOrCreate(
            ['stripe_subscription_id' => $stripeData->id],
            [
                'status' => $stripeData->status,
                'current_period_start' => now(),
                'current_period_end' => now()->addMonth()
            ]
        );
    }
}