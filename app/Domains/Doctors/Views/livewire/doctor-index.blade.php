<x-sweet-alert section="Doctor"> 
<div>
    <div class="card">
        <div class="m-3 row g-3 align-items-center">
            <div class="col-12 col-md-4">
                <input type="text" class="form-control" placeholder="بحث بالاسم، البريد أو التخصص" wire:model.live.500ms="search">
            </div>
            <div class="col-12 col-md-8 text-md-end text-left">
                @if(count($selected) > 0)
                @can('delete doctor')
                <button wire:click="confirmDeleteSelected" class="btn btn-danger">
                    <i class="fas fa-trash"></i> حذف العناصر المحددة ({{ count($selected) }})
                </button>
                @endcan
                @else
                @can('create doctor')
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary mb-2 mb-md-0">
                    <i class="fas fa-plus"></i> إضافة طبيب جديد
                </a>
                @endcan
                @endif
            </div>
        </div>

        <div class="card-header pb-0">
            <h4 class="card-title">قائمة الأطباء</h4>
            @if(count($selected) > 0)
            <div class="text-muted mt-1">تم تحديد {{ count($selected) }} طبيب</div>
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
                            <th>البريد الإلكتروني</th>
                            <th>التخصص</th>
                            <th>الهاتف</th>
                            <th>تاريخ الإضافة</th>
                            <th width="150">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($doctors as $doctor)
                        <tr class="@if(in_array($doctor->id, $selected)) table-active @endif">
                            <td>
                                <input type="checkbox"
                                    wire:model.live="selected"
                                    value="{{ $doctor->id }}"
                                    class="form-check-input">
                            </td>
                            <td>{{ $loop->iteration + ($doctors->currentPage() - 1) * $doctors->perPage() }}</td>
                            <td>{{ $doctor->user?->name ?? '-' }}</td>
                            <td>{{ $doctor->user?->email ?? '-' }}</td>
                            <td>{{ $doctor->specialization ?? '-' }}</td>
                            <td>{{ $doctor->phone ?? '-' }}</td>
                            <td>{{ $doctor->created_at?->format('Y-m-d') }}</td>
                            <td>
                                @can('edit doctor')
                                <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('delete doctor')
                                    @if (auth('admin')->id() !== $doctor->user_id)
                                    <button wire:click="confirmDelete({{ $doctor->id }})" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-user-md fa-2x text-muted mb-2"></i>
                                <br>
                                لا يوجد أطباء
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $doctors->links() }}
            </div>
        </div>
    </div>
</div>
</x-sweet-alert>
