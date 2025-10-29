<?php

namespace App\Domains\Examinations\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionDrugs extends Model
{
    protected $table = 'prescription_drugs';
    
    protected $fillable = [
        'examination_id',
        'drug_name',
        'dose',
        'duration',
        'form',
        'instructions',
        'created_by',
    ];

    public function examination()
    {
        return $this->belongsTo(\App\Domains\Examinations\Models\ExaminationEntity::class, 'examination_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Domains\Auth\Models\Admin::class, 'created_by');
    }
}