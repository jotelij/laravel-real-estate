<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgentProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // check if the user is authenticated and has the role of agent
        $user = $this->user();
        
        if (!$user) {
            return false;
        }

        if($user->is_agent() || $user->is_admin()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'agency_name' => 'required|string|max:255',
            'license_number' => 'required|string|max:255|unique:agent_profiles,license_number',
            'bio' => 'nullable|string',
            'est' => 'nullable|date',
        ];
    }
}
