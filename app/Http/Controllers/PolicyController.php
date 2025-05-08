<?php

namespace App\Http\Controllers;

use App\Http\Requests\PolicyRequest;
use App\Models\Policy;
use App\Services\PolicyService;
use Illuminate\Support\Facades\Auth;

class PolicyController extends Controller
{
    public function __construct(private PolicyService $policyService)
    {
        $this->authorizeResource(Policy::class, 'policy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $policies = Policy::with([
            'policyHolder',
            'drivers',
            'vehicles.garagingAddress',
            'vehicles.coverages'
        ])->where('user_id', Auth::id())->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $policies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PolicyRequest $request)
    {
        try {
            $policy = $this->policyService->createPolicy($request->validated(), Auth::user());

            return response()->json([
                'success' => true,
                'message' => 'Policy created successfully.',
                'data' => $policy
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create policy.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Policy $policy)
    {
        return response()->json([
            'success' => true,
            'data' => $policy->load([
                'policyHolder',
                'drivers',
                'vehicles.garagingAddress',
                'vehicles.coverages'
            ])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PolicyRequest $request, Policy $policy)
    {
        try {
            $updatedPolicy = $this->policyService->updatePolicy($request->validated(), $policy);

            return response()->json([
                'success' => true,
                'message' => 'Policy updated successfully.',
                'data' => $updatedPolicy
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update policy.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Policy $policy)
    {
        try {
            $policy->delete();

            return response()->json([
                'success' => true,
                'message' => 'Policy deleted successfully.'
            ], 204);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete policy.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function downloadPolicyPDF(Policy $policy)
    {
        try {
            return $this->policyService->generatePolicyPDF($policy);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate policy document.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
