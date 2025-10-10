<?php

namespace App\Domains\Services\Models;

use App\Domains\Auth\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class ServiceEntity extends Model
{
    protected $table = 'services';
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
