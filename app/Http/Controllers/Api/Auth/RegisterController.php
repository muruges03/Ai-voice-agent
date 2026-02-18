<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    public function register(Request $request)
    {
        try {
            $request->validate([
                'company_name' => 'required',
                'domain' => 'required|unique:domains,domain',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6'
            ]);

            $slug = Str::slug($request->domain);

            // Create Tenant
            $tenant = Tenant::create([
                'id' => $slug,
            ]);

            // Create Domain
            $tenant->domains()->create([
                'domain' => $request->domain
            ]);

            // Create Central User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'tenant_id' => $tenant->id,
            ]);

            // Create token
            $token = $user->createToken('api-token')->plainTextToken;

            return $this->successResponse([
                'token' => $token,
                'tenant_id' => $tenant->id
            ], 'User created successfully', 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse('Validation Error', 422, $e->errors());
        }
    }
}
