<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'owner',
        'location',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];
}
