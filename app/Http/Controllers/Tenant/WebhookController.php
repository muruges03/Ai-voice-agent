<?php

namespace App\Http\Controllers\tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\CallLog;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleCall(Request $request)
    {
        CallLog::create([
            'agent_id' => $request->agent_id,
            'call_sid' => $request->CallSid,
            'phone_number' => $request->From,
            'duration' => $request->CallDuration ?? 0,
            'status' => $request->CallStatus
        ]);

        return response()->json(['status' => 'logged']);
    }
}
