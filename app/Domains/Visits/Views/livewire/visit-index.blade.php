<div>
    <div class="card">
        <div class="m-3 row g-3 align-items-center">
            <div class="col-12 col-md-3">
                <input type="text" class="form-control" placeholder="بحث بالاسم، الخدمة، أو الملاحظات" wire:model.live.500ms="search">
            </div>
            <div class="col-12 col-md-3">
                <select class="form-control" wire:model.live="statusFilter">
                    <option value="">جميع الحالات</option>
                    <option value="pending">معلق</option>
                    <option value="completed">مكتمل</option>
                    <option value="canceled">ملغي</option>
                </select>
            </div>
            <div class="col-12 col-md-6 text-md-end text-left">
                @if(count($selected) > 0)
                <button wire:click="confirmDeleteSelected" class="btn btn-danger">
                    <i class="fas fa-trash"></i> حذف الزيارات المحددة ({{ count($selected) }})
                </button>
                @else
                <a href="{{ route('admin.visits.create') }}" class="btn btn-primary mb-2 mb-md-0">
                    <i class="fas fa-plus"></i> إضافة زيارة جديدة
                </a>
                @endif
            </div>
        </div>
        <div class="card-header pb-0">
            <h4 class="card-title">قائمة الزيارات</h4>
            @if(count($selected) > 0)
            <div class="text-muted mt-1">تم تحديد {{ count($selected) }} زيارة</div>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table text-md-nowrap">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" wire:model.live="selectAll">
                            </th>
                            <th>#</th>
                            <th>المريض</th>
                            <th>الخدمة</th>
                            <th>التاريخ</th>
                            <th>الوقت</th>
                            <th>السعر</th>
                            <th>الحالة</th>
                            <th width="150">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($visits as $visit)
                        <tr class="@if(in_array($visit->id, $selected)) table-active @endif">
                            <td>
                                <input type="checkbox"
                                    wire:model.live="selected"
                                    value="{{ $visit->id }}"
                                    class="form-check-input">
                            </td>
                            <td>{{ $loop->iteration + ($visits->currentPage() - 1) * $visits->perPage() }}</td>
                            <td>{{ optional($visit->patient->user)->name }}</td>
                            <td>{{ $visit->service->name }}</td>
                            <td>{{ $visit->visit_date->format('Y-m-d') }}</td>
                            <td>{{ $visit->visit_time->format('H:i') }}</td>
                            <td>{{ $visit->formatted_price }}</td>
                            <td>
                                @if($visit->status == 'pending')
                                <span class="badge bg-warning text-dark">معلق</span>
                                @elseif($visit->status == 'completed')
                                <span class="badge bg-success text-light">مكتمل</span>
                                @elseif($visit->status == 'canceled')
                                <span class="badge bg-danger text-light">ملغي</span>
                                @else
                                <span class="badge bg-secondary text-light">غير محدد</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.visits.edit', $visit->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button wire:click="confirmDelete({{ $visit->id }})"
                                    class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="fas fa-calendar-times fa-2x text-muted mb-2"></i>
                                <br>
                                لا توجد زيارات
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $visits->links() }}
            </div>
        </div>
    </div>
</div>
