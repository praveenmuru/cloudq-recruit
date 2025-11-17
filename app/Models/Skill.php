<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name'];

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_skill');
    }
}
