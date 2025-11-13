<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'point_of_contact',
        'point_of_contact_number',
    ];

    public function requests()
    {
        return $this->hasMany(ClientRequest::class);
    }
}
