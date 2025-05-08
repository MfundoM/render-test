<?php

namespace App\Policies;

use App\Models\Policy;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PolicyPolicy
{

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Policy $policy)
    {
        return $user->id === $policy->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Policy $policy)
    {
        return $user->id === $policy->user_id;
    }

    public function delete(User $user, Policy $policy)
    {
        return $user->id === $policy->user_id;
    }

    public function downloadPolicyPDF(User $user, Policy $policy)
    {
        return $user->id === $policy->user_id;
    }
}
