<?php

namespace App\Domains\Patients\Models;

use App\Domains\Auth\Models\Admin;
use App\Domains\Users\Models\UserEntity;
use Illuminate\Database\Eloquent\Model;

class PatientEntity extends Model
{
    protected $table = 'patients';
    protected $fillable = [
        'user_id',
        'phone',
        'gender',
        'birth_date',
        'address',
        'national_id',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(UserEntity::class);
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}