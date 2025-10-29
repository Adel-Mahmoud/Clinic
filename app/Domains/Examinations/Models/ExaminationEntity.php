<?php

namespace App\Domains\Examinations\Models;

use Illuminate\Database\Eloquent\Model;

class ExaminationEntity extends Model
{
    protected $table = 'examinations';

    protected $fillable = ['visit_id', 'diagnosis', 'symptoms', 'notes', 'created_by'];

    public function visit()
    {
        return $this->belongsTo(\App\Domains\Visits\Models\VisitEntity::class, 'visit_id');
    }

    public function attachments()
    {
        return $this->hasMany(ExaminationAttachment::class);
    }

    public function drugs()
    {
        return $this->hasMany(PrescriptionDrugs::class);
    }

    public function creator()
    {
        return $this->belongsTo(\App\Domains\Auth\Models\Admin::class, 'created_by');
    }
}
