<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateRequest extends FormRequest
{
    public function authorize()
    {
        // Adjust authorization logic as needed
        return auth()->check();
    }

   public function rules()
{
    return [
        'skills' => 'nullable|array',
        'skills.*' => 'nullable',

        'location_id' => 'nullable',
        'preferred_locations' => 'nullable|array',
        'preferred_locations.*' => 'nullable',

        'client' => 'nullable|string|max:255',
        'date_of_joining' => 'nullable|date',
        'title' => 'nullable|string|max:255',
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:30',
        'alternate_phone' => 'nullable|string|max:30',
        'email' => 'nullable|email|max:255',
        'current_company' => 'nullable|string|max:255',
        'current_role' => 'nullable|string|max:255',
        'total_exp' => 'nullable|numeric|min:0|max:100',
        'relevant_exp' => 'nullable|numeric|min:0|max:100',
        'ctc' => 'nullable|numeric|min:0',
        'ectc' => 'nullable|numeric|min:0',
        'notice_period' => 'nullable|string|max:255',
        'earliest_availability' => 'nullable|string|max:255',
        'work_type' => 'nullable|in:Remote,Inoffice,Hybrid',
        'reason_for_job_change' => 'nullable|string',
        'remarks' => 'nullable|string',
        'resume_link' => 'nullable|url|max:1000',
    ];
}

}
