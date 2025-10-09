<div>
    <div class="card">
        <div class="m-3 row g-3 align-items-center">
            <div class="col-12 col-md-4">
                <input type="text" class="form-control" placeholder="بحث بالاسم أو البريد أو الهاتف" wire:model.live.500ms="search">
            </div>
            <div class="col-12 col-md-8 text-md-end text-left">
                @if(count($selected) > 0)
                <button wire:click="confirmDeleteSelected" class="btn btn-danger">
                    <i class="fas fa-trash"></i> حذف العناصر المحددة ({{ count($selected) }})
                </button>
                @else
                <a href="{{ route('admin.patients.create') }}" class="btn btn-primary mb-2 mb-md-0">
                    <i class="fas fa-plus"></i> إضافة مريض جديد
                </a>
                @endif
            </div>
        </div>
        <div class="card-header pb-0">
            <h4 class="card-title">قائمة المرضى</h4>
            @if(count($selected) > 0)
            <div class="text-muted mt-1">تم تحديد {{ count($selected) }} سجل</div>
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
                            <th>الهاتف</th>
                            <th>الهوية</th>
                            <th>تاريخ الإنشاء</th>
                            <th width="150">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patients as $patient)
                        <tr class="@if(in_array($patient->id, $selected)) table-active @endif">
                            <td>
                                <input type="checkbox"
                                    wire:model.live="selected"
                                    value="{{ $patient->id }}"
                                    class="form-check-input">
                            </td>
                            <td>{{ $loop->iteration + ($patients->currentPage() - 1) * $patients->perPage() }}</td>
                            <td>{{ optional($patient->user)->name }}</td>
                            <td>{{ optional($patient->user)->email }}</td>
                            <td>{{ $patient->phone }}</td>
                            <td>{{ $patient->national_id }}</td>
                            <td>{{ $patient->created_at?->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button wire:click="confirmDelete({{ $patient->id }})"
                                    class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                لا يوجد مرضى
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $patients->links() }}
            </div>
        </div>
    </div>
</div>

 
