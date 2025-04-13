<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'sap_code',
        'name',
        'type',
        'city',
        'payment_project',
        'is_active',
        'address',
        'npwp',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
