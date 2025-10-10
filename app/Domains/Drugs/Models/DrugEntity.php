<?php

namespace App\Domains\Drugs\Models;

use App\Domains\Auth\Models\Admin;
use App\Domains\Users\Models\UserEntity;
use Illuminate\Database\Eloquent\Model;

class DrugEntity extends Model
{
    protected $table = 'drugs';
    
    protected $fillable = [
        'name',
        'form',
        'strength',
        'generic_name',
        'manufacturer',
        'barcode',
        'default_dosage',
        'default_instructions',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
