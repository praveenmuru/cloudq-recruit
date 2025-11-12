<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client',
        'date_of_joining',
        'title',
        'keywords',
        'name',
        'phone',
        'alternate_phone',
        'email',
        'current_company',
        'current_role',
        'total_exp',
        'relevant_exp',
        'ctc',
        'ectc',
        'notice_period',
        'earliest_availability',
        'location',
        'preferred_location',
        'work_type',
        'reason_for_job_change',
        'remarks',
        'resume_link',
    ];

    protected $casts = [
        'date_of_joining' => 'date',
        'keywords' => 'array',
        'total_exp' => 'decimal:2',
        'relevant_exp' => 'decimal:2',
        'ctc' => 'decimal:2',
        'ectc' => 'decimal:2',
    ];

    // Helper to join keywords string
    public function keywordsString()
    {
        return $this->keywords ? implode(', ', $this->keywords) : '';
    }
}
