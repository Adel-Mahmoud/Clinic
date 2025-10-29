<?php

namespace App\Domains\Examinations\Models;

use Illuminate\Database\Eloquent\Model;

class ExaminationAttachment extends Model
{
    protected $table = 'examination_attachments';
    
    protected $fillable = [
        'examination_id',
        'file_path',
        'file_type',
        'notes',
        'created_by',
    ];

    public function visit()
    {
        return $this->belongsTo(\App\Domains\Visits\Models\VisitEntity::class, 'visit_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Domains\Auth\Models\Admin::class, 'created_by');
    }
}