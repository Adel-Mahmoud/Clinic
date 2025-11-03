<?php

namespace App\Domains\Examinations\Models;

use Illuminate\Database\Eloquent\Model;

class ExaminationEntity extends Model
{
    protected $table = 'examinations';

    protected $fillable = ['visit_id', 'diagnosis', 'symptoms', 'test_type', 'test_details', 'notes', 'created_by'];

    public function visit()
    {
        return $this->belongsTo(\App\Domains\Visits\Models\VisitEntity::class, 'visit_id');
    }

    public function attachments()
    {
        return $this->hasMany(ExaminationAttachment::class, 'examination_id');
    }

    public function drugs()
    {
        return $this->hasMany(PrescriptionDrugs::class, 'examination_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Domains\Auth\Models\Admin::class, 'created_by');
    }
}
