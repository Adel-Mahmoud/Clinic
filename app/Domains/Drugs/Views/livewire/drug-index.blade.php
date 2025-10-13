<div>
    <div class="card">
        <div class="m-3 row g-3 align-items-center">
            <div class="col-12 col-md-4">
                <input type="text" class="form-control" placeholder="بحث بالاسم أو الاسم العلمي أو الشركة المصنعة" wire:model.live.500ms="search">
            </div>
            <div class="col-12 col-md-8 text-md-end text-left">
                @if(count($selected) > 0)
                <button wire:click="confirmDeleteSelected" class="btn btn-danger">
                    <i class="fas fa-trash"></i> حذف العناصر المحددة ({{ count($selected) }})
                </button>
                @else
                <a href="{{ route('admin.drugs.create') }}" class="btn btn-primary mb-2 mb-md-0">
                    <i class="fas fa-plus"></i> إضافة دواء جديد
                </a>
                @endif
            </div>
        </div>
        <div class="card-header pb-0">
            <h4 class="card-title">قائمة الأدوية</h4>
            @if(count($selected) > 0)
            <div class="text-muted mt-1">تم تحديد {{ count($selected) }} دواء</div>
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
                            <th>الاسم العلمي</th>
                            <th>الشكل</th>
                            <th>التركيز</th>
                            <th>الحالة</th>
                            <th>تاريخ الإنشاء</th>
                            <th width="150">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($drugs as $drug)
                        <tr class="@if(in_array($drug->id, $selected)) table-active @endif">
                            <td>
                                <input type="checkbox"
                                    wire:model.live="selected"
                                    value="{{ $drug->id }}"
                                    class="form-check-input">
                            </td>
                            <td>{{ $loop->iteration + ($drugs->currentPage() - 1) * $drugs->perPage() }}</td>
                            <td>{{ $drug->name }}</td>
                            <td>{{ $drug->generic_name ?? '-' }}</td>
                            <td>{{ $drug->form ?? '-' }}</td>
                            <td>{{ $drug->strength ?? '-' }}</td>
                            <td>
                                @if($drug->is_active)
                                    <span class="badge bg-success text-light">نشط</span>
                                @else
                                    <span class="badge bg-danger text-light">غير نشط</span>
                                @endif
                            </td>
                            <td>{{ $drug->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.drugs.edit', $drug->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button wire:click="confirmDelete({{ $drug->id }})"
                                    class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <i class="fas fa-pills fa-2x text-muted mb-2"></i>
                                <br>
                                لا يوجد أدوية
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $drugs->links() }}
            </div>
        </div>
    </div>
</div>
