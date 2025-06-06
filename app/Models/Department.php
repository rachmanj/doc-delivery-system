<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'project',
        'location_code',
        'transit_code',
        'akronim',
        'sap_code',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
