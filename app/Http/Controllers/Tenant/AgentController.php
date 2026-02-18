<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function index()
    {
        return Agent::latest()->get();
    }

    public function store(Request $request)
    {
        $agent = Agent::create([
            'name' => $request->name,
            'voice_provider' => $request->voice_provider,
            'voice_model' => $request->voice_model,
            'system_prompt' => $request->system_prompt,
            'created_by' => Auth::user()->id
        ]);

        return response()->json($agent);
    }

    public function update(Request $request, Agent $agent)
    {
        $agent->update($request->all());
        return response()->json($agent);
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
