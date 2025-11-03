<div>
    <div class="d-flex justify-content-end mb-2">
        <input type="text" wire:model.live="search" class="form-control w-25" placeholder="بحث...">
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center visits-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>التاريخ</th>
                    <th>نوع الخدمة</th>
                    <th>الأعراض</th>
                    <th>التشخيص</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($visits as $index => $visit)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $visit->created_at->format('Y-m-d') }}</td>
                    <td>
                        <span class="badge bg-success text-light">{{ $visit->visit->service->name }}</span>
                    </td>
                    <td>{{ $visit->symptoms }}</td>
                    <td>{{ $visit->diagnosis }}</td>
                    <td>
                        <a href="{{ route('admin.examinations.show',$visit->id) }}" class="btn btn-outline-primary btn-sm"><i class="fe fe-eye"></i></a>
                        <a href="{{ route('admin.examinations.print', $visit->id) }}"
                            class="btn btn-outline-secondary btn-sm">
                            <i class="fe fe-printer"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">لا توجد زيارات سابقة</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $visits->links() }}
    </div>
</div>