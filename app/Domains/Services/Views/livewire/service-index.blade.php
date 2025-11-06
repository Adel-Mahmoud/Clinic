<div>
    <div class="card">
        <div class="m-3 row g-3 align-items-center">
            <div class="col-12 col-md-4">
                <input type="text" class="form-control" placeholder="بحث بالاسم أو الوصف" wire:model.live.500ms="search">
            </div>
            <div class="col-12 col-md-8 text-md-end text-left">
                @if(count($selected) > 0)
                @can('delete service')
                <button wire:click="confirmDeleteSelected" class="btn btn-danger">
                    <i class="fas fa-trash"></i> حذف العناصر المحددة ({{ count($selected) }})
                </button>
                @endcan
                @else
                @can('create service')
                <a href="{{ route('admin.services.create') }}" class="btn btn-primary mb-2 mb-md-0">
                    <i class="fas fa-plus"></i> إضافة خدمة جديدة
                </a>
                @endcan
                @endif
            </div>
        </div>
        <div class="card-header pb-0">
            <h4 class="card-title">قائمة الخدمات</h4>
            @if(count($selected) > 0)
            <div class="text-muted mt-1">تم تحديد {{ count($selected) }} خدمة</div>
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
                            <th>الاسم</th>
                            <th>السعر</th>
                            <th>الوصف</th>
                            <th>الحالة</th>
                            <th>تاريخ الإنشاء</th>
                            <th width="150">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $service)
                        <tr class="@if(in_array($service->id, $selected)) table-active @endif">
                            <td>
                                <input type="checkbox"
                                    wire:model.live="selected"
                                    value="{{ $service->id }}"
                                    class="form-check-input">
                            </td>
                            <td>{{ $loop->iteration + ($services->currentPage() - 1) * $services->perPage() }}</td>
                            <td>{{ $service->name }}</td>
                            <td>{{ number_format($service->price, 2) }} ج.م</td>
                            <td>{{ Str::limit($service->description, 50) ?? '-' }}</td>
                            <td>
                                @if($service->is_active)
                                    <span class="badge bg-success">نشط</span>
                                @else
                                    <span class="badge bg-danger">غير نشط</span>
                                @endif
                            </td>
                            <td>{{ $service->created_at->format('Y-m-d') }}</td>
                            <td>
                                @can('edit service')
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('delete service')
                                <button wire:click="confirmDelete({{ $service->id }})"
                                    class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-stethoscope fa-2x text-muted mb-2"></i>
                                <br>
                                لا يوجد خدمات
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</div>
