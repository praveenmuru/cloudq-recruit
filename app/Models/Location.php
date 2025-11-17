<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name'];

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'location_id');
    }

    public function preferredBy()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_preferred_location');
    }
}
