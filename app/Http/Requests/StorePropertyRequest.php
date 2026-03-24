<?php

namespace App\Http\Requests;

use App\Enums\ListingType;
use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class StorePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        if (!$user || !$user->is_agent()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'           => ['required', 'string', 'max:255'],
            'slug'            => ['nullable', 'string', 'max:255', 'unique:properties,slug'],
            'description'     => ['required', 'string'],
            'property_type'   => ['required', new Enum(PropertyType::class)], // adjust Enum values as needed
            'listing_type'    => ['required', new Enum(ListingType::class)], // adjust Enum values as needed
            // 'status'          => ['required', new Enum(PropertyStatus::class)], // adjust Enum values as needed
            'price'           => ['required', 'numeric', 'min:0'],
            'bedrooms'        => ['nullable', 'integer', 'min:0', 'max:255'],
            'bathrooms'       => ['nullable', 'integer', 'min:0', 'max:255'],
            'garages'         => ['nullable', 'integer', 'min:0', 'max:255'],
            'floor_area'      => ['nullable', 'numeric', 'min:0'],
            'land_area'       => ['nullable', 'numeric', 'min:0'],
            'year_built'      => ['nullable', 'integer', 'digits:4', 'min:1800', 'max:' . (date('Y') + 1)],
            'is_featured'     => ['sometimes', 'boolean'],
            'virtual_tour_link' => ['nullable', 'string', 'url', 'max:255'],
        ];
    }
}
