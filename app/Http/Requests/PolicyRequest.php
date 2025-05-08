<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PolicyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'policy_effective_date' => ['required', 'date'],
            'policy_expiration_date' => ['required', 'date'],

            'policy_holder.first_name' => ['required', 'string', 'min:2'],
            'policy_holder.last_name' => ['required', 'string', 'min:2'],
            'policy_holder.street' => ['required', 'string'],
            'policy_holder.city' => ['required', 'string'],
            'policy_holder.state' => ['required', 'string'],
            'policy_holder.zip' => ['required', 'string'],

            'drivers' => ['required', 'array'],
            'drivers.*.first_name' => ['required', 'string', 'min:2'],
            'drivers.*.last_name' => ['required', 'string', 'min:2'],
            'drivers.*.age' => ['required', 'integer', 'between:20,35'],
            'drivers.*.gender' => ['required', 'string'],
            'drivers.*.marital_status' => ['required', 'string'],
            'drivers.*.license_number' => ['required', 'string'],
            'drivers.*.license_state' => ['required', 'string'],
            'drivers.*.license_status' => ['required', 'string'],
            'drivers.*.license_effective_date' => ['required', 'date'],
            'drivers.*.license_expiration_date' => ['required', 'date'],
            'drivers.*.license_class' => ['required', 'string'],

            'vehicles' => ['required', 'array'],
            'vehicles.*.year' => ['required', 'integer'],
            'vehicles.*.make' => ['required', 'string'],
            'vehicles.*.model' => ['required', 'string'],
            'vehicles.*.vin' => ['required', 'string'],
            'vehicles.*.usage' => ['required', 'string'],
            'vehicles.*.primary_use' => ['required', 'string'],
            'vehicles.*.annual_mileage' => ['required', 'integer'],
            'vehicles.*.ownership' => ['required', 'string'],

            'vehicles.*.garaging_address.street' => ['required', 'string'],
            'vehicles.*.garaging_address.city' => ['required', 'string'],
            'vehicles.*.garaging_address.state' => ['required', 'string'],
            'vehicles.*.garaging_address.zip' => ['required', 'string'],

            'vehicles.*.coverages' => ['required', 'array'],
            'vehicles.*.coverages.*.type' => ['required', 'string'],
            'vehicles.*.coverages.*.limit' => ['required', 'integer'],
            'vehicles.*.coverages.*.deductible' => ['required', 'integer']
        ];
    }

    public function messages()
    {
        return [
            'policy_effective_date.required' => 'The effective date is required.',
            'policy_expiration_date.required' => 'The expiration date is required.',

            'policy_holder.first_name.required' => 'Policy holder first name is required.',
            'policy_holder.first_name.min' => 'Policy holder first name must be at least 2 characters.',
            'policy_holder.last_name.required' => 'Policy holder last name is required.',
            'policy_holder.last_name.min' => 'Policy holder last name must be at least 2 characters.',
            'policy_holder.street.required' => 'Policy holder street address is required.',
            'policy_holder.city.required' => 'Policy holder city is required.',
            'policy_holder.state.required' => 'Policy holder state is required.',
            'policy_holder.zip.required' => 'Policy holder ZIP code is required.',

            'drivers.required' => 'At least one driver must be provided.',
            'drivers.*.first_name.required' => 'Driver first name is required.',
            'drivers.*.first_name.min' => 'Driver first name must be at least 2 characters.',
            'drivers.*.last_name.required' => 'Driver last name is required.',
            'drivers.*.last_name.min' => 'Driver last name must be at least 2 characters.',
            'drivers.*.age.required' => 'Driver age is required.',
            'drivers.*.age.integer' => 'Driver age must be a number.',
            'drivers.*.age.between'  => 'Driver age must be between 20 and 35.',
            'drivers.*.gender.required' => 'Driver gender is required.',
            'drivers.*.marital_status.required' => 'Driver marital status is required.',
            'drivers.*.license_number.required' => 'Driver license number is required.',
            'drivers.*.license_state.required' => 'Driver license state is required.',
            'drivers.*.license_status.required' => 'Driver license status is required.',
            'drivers.*.license_effective_date.required' => 'Driver license effective date is required.',
            'drivers.*.license_expiration_date.required' => 'Driver license expiration date is required.',
            'drivers.*.license_class.required' => 'Driver license class is required.',

            'vehicles.required' => 'At least one vehicle must be provided.',
            'vehicles.*.year.required' => 'vehicle year is required.',
            'vehicles.*.make.required' => 'vehicle make is required.',
            'vehicles.*.model.required' => 'vehicle model is required.',
            'vehicles.*.vin.required' => 'vehicle VIN is required.',
            'vehicles.*.usage.required' => 'vehicle usage is required.',
            'vehicles.*.primary_use.required' => 'vehicle primary use is required.',
            'vehicles.*.annual_mileage.required' => 'vehicle annual mileage is required.',
            'vehicles.*.ownership.required' => 'vehicle ownership status is required.',

            'vehicles.*.garaging_address.street.required' => 'Garaging street address is required.',
            'vehicles.*.garaging_address.city.required' => 'Garaging city is required.',
            'vehicles.*.garaging_address.state.required' => 'Garaging state is required.',
            'vehicles.*.garaging_address.zip.required' => 'Garaging ZIP code is required.',

            'vehicles.*.coverages.required' => 'Coverages are required for vehicle.',
            'vehicles.*.coverages.*.type.required' => 'Coverage must have a type.',
            'vehicles.*.coverages.*.limit.required' => 'Coverage must have a limit.',
            'vehicles.*.coverages.*.deductible.required' => 'Coverage must have a deductible.',
        ];
    }
}
