<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRequest extends Model
{
    use HasFactory;


    public function client()
    {
        return $this->belongsTo(Client::class);
    }
 
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'client_request_skill');
    }

    public function locations()
{
    return $this->belongsToMany(Location::class, 'client_request_location');
}

    protected $fillable = [
        'client_id',
        'client_name',
        'role_id',
        'role',
        'experience',
        'location',
        'remarks',
        'panel_availability',
    ];
}
