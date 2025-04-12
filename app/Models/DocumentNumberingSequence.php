<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentNumberingSequence extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_type',
        'department_code',
        'year',
        'sequence'
    ];
} 