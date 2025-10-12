<?php

namespace App\Domains\Visits\Models;

use App\Domains\Patients\Models\PatientEntity;
use App\Domains\Services\Models\ServiceEntity;
use Illuminate\Database\Eloquent\Model;

class VisitEntity extends Model
{
    protected $table = 'visits';
    protected $fillable = [
        'patient_id',
        'service_id',
        'visit_date',
        'visit_time',
        'price',
        'status',
        'notes',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'visit_time' => 'datetime:H:i',
        'price' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(PatientEntity::class);
    }

    public function service()
    {
        return $this->belongsTo(ServiceEntity::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending' => '<span class="badge badge-warning">معلق</span>',
            'completed' => '<span class="badge badge-success">مكتمل</span>',
            'canceled' => '<span class="badge badge-danger">ملغي</span>',
            default => '<span class="badge badge-secondary">غير محدد</span>'
        };
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' ج.م';
    }

    public function getQueuePositionAttribute()
    {
        if ($this->status !== 'pending') {
            return null;
        }

        return VisitEntity::where('status', 'pending')
            ->where('visit_date', $this->visit_date)
            ->where(function ($q) {
                $q->where('visit_time', '<', $this->visit_time)
                    ->orWhere(function ($q2) {
                        $q2->where('visit_time', $this->visit_time)
                            ->where('id', '<', $this->id);
                    });
            })
            ->count() + 1;
    }
}
