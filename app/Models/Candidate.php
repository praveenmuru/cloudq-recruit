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
        'location_id',
        'work_type',
        'reason_for_job_change',
        'remarks',
        'resume_link',
    ];

    protected $casts = [
        'date_of_joining' => 'date',
    ];

    // ------------------- Relationships -------------------

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'candidate_skill');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function preferredLocations()
    {
        return $this->belongsToMany(Location::class, 'candidate_preferred_location');
    }

    // Helper Accessors
    public function skillNames()
    {
        return $this->skills->pluck('name')->implode(', ');
    }

    public function preferredLocationNames()
    {
        return $this->preferredLocations->pluck('name')->implode(', ');
    }

    public function keywordsString()
{
    // Example: if Candidate has a relation to skills
    return $this->skills->pluck('name')->implode(', ');
}
}
