<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOnboardingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        $allowedModules = ['school', 'hospital', 'property', 'pos'];
        $lockedModule = (string) $this->input('locked_module');
        $moduleLocked = in_array($lockedModule, $allowedModules, true);
        $requestedModules = array_values(array_filter(
            array_merge((array) $this->input('modules', []), $moduleLocked ? [$lockedModule] : []),
            fn ($module) => is_string($module) && $module !== ''
        ));
        $schoolSelected = in_array('school', $requestedModules, true);

        return [
            'company_name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'size:2'],
            'timezone' => ['required', 'string', 'max:64'],
            'currency' => ['required', 'string', 'size:3'],
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user()?->id)],
            'admin_phone' => ['nullable', 'string', 'max:20'],
            'locked_module' => ['nullable', Rule::in($allowedModules)],
            'modules' => [Rule::requiredIf(! $moduleLocked), 'array', 'min:1'],
            'modules.*' => ['string', Rule::in($allowedModules)],
            'start_trial' => ['nullable', 'boolean'],
            'trial_days' => ['nullable', 'integer', 'min:1', 'max:30'],
            'school_registration_number' => [Rule::excludeIf(! $schoolSelected), 'nullable', 'string', 'max:100'],
            'school_type' => [Rule::excludeIf(! $schoolSelected), 'required', Rule::in(['primary', 'secondary', 'college', 'university', 'mixed'])],
            'admission_term' => [Rule::excludeIf(! $schoolSelected), 'required', Rule::in(['rolling', 'term_1', 'term_2', 'term_3'])],
            'student_capacity' => [Rule::excludeIf(! $schoolSelected), 'required', 'integer', 'min:1', 'max:50000'],
            'academic_year_start' => [Rule::excludeIf(! $schoolSelected), 'required', 'date'],
            'fee_due_day' => [Rule::excludeIf(! $schoolSelected), 'required', 'integer', 'min:1', 'max:31'],
            'fee_reminder_email' => [Rule::excludeIf(! $schoolSelected), 'nullable', 'boolean'],
            'fee_reminder_sms' => [Rule::excludeIf(! $schoolSelected), 'nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'modules.required' => 'Select at least one module to continue.',
            'locked_module.in' => 'Invalid locked module detected. Please restart onboarding from the app page.',
            'school_type.required' => 'Select the school type to configure the School module.',
            'admission_term.required' => 'Select the admission intake mode for your school.',
            'student_capacity.required' => 'Enter an estimated student capacity.',
            'academic_year_start.required' => 'Select the academic year start date.',
            'fee_due_day.required' => 'Provide a monthly fee due day between 1 and 31.',
        ];
    }
}
