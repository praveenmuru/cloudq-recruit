<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'role',
        'candidate_name',
        'cv_status',
        'interview_date',
        'interview_time',
        'client_round',
        'interview_status',
        'offer_status',
        'offered_salary',
        'joining_date',
    ];
}
