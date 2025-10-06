<?php

namespace App\Domains\Doctors\Models;

use App\Domains\Auth\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class DoctorEntity extends Model
{
    protected $table = 'doctors';

    protected $fillable = [
        'user_id',
        'specialization',
        'phone',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(Admin::class);
    }
}
