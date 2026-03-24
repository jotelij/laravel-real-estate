<?php

namespace App\Policies;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EnquiryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Enquiry $enquiry): bool
    {
        return $user->id === $enquiry->sender_id || $user->id === $enquiry->agent_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_buyer();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Enquiry $enquiry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Enquiry $enquiry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Enquiry $enquiry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Enquiry $enquiry): bool
    {
        return false;
    }
}
