<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRequest extends Model
{
    use HasFactory;

protected $fillable = [
    'client_id',
    'client_name',
    'point_of_contact',
    'point_of_contact_number',
    'role',
    'position_status',
    'skills_sets',
    'experience',
    'location',
    'remarks',
    'panel_availability',
];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
