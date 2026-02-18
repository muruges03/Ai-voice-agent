<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Tenant\CallLog;
use Illuminate\Http\Request;

class VoiceController extends Controller
{
    public function handleIncoming(Request $request)
    {
        $agent = Agent::where('phone_number', $request->To)->first();

        if (!$agent) {
            return response('<Response><Say>No agent configured</Say></Response>')
                ->header('Content-Type', 'text/xml');
        }
        $tenant = tenant();

        if ($tenant->used_minutes >= $tenant->monthly_minutes) {
            return response('<Response><Say>Usage limit reached</Say></Response>')
                ->header('Content-Type', 'text/xml');
        }

        $call = CallLog::create([
            'agent_id' => $agent->id,
            'call_sid' => $request->CallSid,
            'phone_number' => $request->From,
            'status' => 'in-progress'
        ]);

        $reply = $this->generateAIResponse($agent, "Hello");

        return response(
            "<Response><Say>{$reply}</Say></Response>"
        )->header('Content-Type', 'text/xml');
    }

    private function generateAIResponse($agent, $message)
    {
        return "Hello, this is {$agent->name}. How can I help you?";
    }

    public function callStatus(Request $request)
    {
        $call = CallLog::where('call_sid', $request->CallSid)->first();

        if ($call) {
            $call->update([
                'duration' => $request->CallDuration,
                'status' => $request->CallStatus
            ]);

            $tenant = tenant();
            $tenant->increment('used_minutes', ceil($request->CallDuration / 60));
        }

        return response()->json(['ok']);
    }
}
