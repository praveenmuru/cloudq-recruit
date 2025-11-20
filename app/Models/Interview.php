<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

protected $fillable = [
    'client_id',
    'candidate_id',
    'role',
    'cv_status_id',
    'interview_status_id',
    'offer_status_id',
    'interview_date',
    'interview_time',
    'client_round',
    'offered_salary',
    'joining_date',
];
    public function client()
{
    return $this->belongsTo(Client::class);
}

public function candidate()
{
    return $this->belongsTo(Candidate::class);
}
public function cvStatus()
{
    return $this->belongsTo(CvStatus::class);
}

public function interviewStatus()
{
    return $this->belongsTo(InterviewStatus::class);
}

public function offerStatus()
{
    return $this->belongsTo(OfferStatus::class);
}


}
