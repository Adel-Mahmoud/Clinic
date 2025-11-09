@section('css')
<style>
    @media print {
    body * {
        visibility: hidden;
    }

    .print-area, .print-area * {
        visibility: visible;
    }

    table {
        page-break-inside: auto;
    }

    thead { display: table-header-group; }
    tfoot { display: table-footer-group; }

    @page {
        margin: 10mm;
    }
}

</style>
@endsection
<div class="container py-4">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-3">
                    <label class="form-label">نوع الخدمة</label>
                    <select class="form-control" wire:model.change="serviceId">
                        <option value="" selected>كل الخدمات</option>
                        @foreach($getAllServices as $serves)
                        <option value="{{ $serves->id }}">{{ $serves->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">الفترة</label>
                    <select class="form-control" wire:model.change="period">
                        <option value="daily">يومي</option>
                        <option value="weekly">أسبوعي</option>
                        <option value="monthly">شهري</option>
                        <option value="quarterly">ربع سنوي</option>
                        <option value="yearly">سنوي</option>
                        <option value="custom">مخصص</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">من تاريخ</label>
                    <input type="date" class="form-control" wire:model.defer="startDate" @disabled($period !=='custom' )>
                </div>

                <div class="col-md-2">
                    <label class="form-label">إلى تاريخ</label>
                    <input type="date" class="form-control" wire:model.defer="endDate" @disabled($period !=='custom' )>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    @can('generate reports')
                    <button class="btn btn-primary w-100" wire:click="generate">
                        <i class="fas fa-chart-bar me-2"></i>توليد التقرير
                    </button>
                    @endcan
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>نتائج التقرير</span>
            <button class="btn btn-secondary btn-sm" onclick="window.print();">
                <i class="fas fa-print me-1"></i> طباعة
            </button>
        </div>
        <div class="card-body p-0 print-area">

            <div class="table-responsive">
                <table class="table table-striped align-middle text-center mb-0">
                    <thead class="table-primary sticky-top">
                        <tr class="text-center align-middle" style="height: 40px;">
                            <th class="text-center align-middle">التاريخ</th>
                            <th class="text-center align-middle">المريض</th>
                            <th class="text-center align-middle">الخدمة</th>
                            <th class="text-center align-middle">السعر</th>
                            <th class="text-center align-middle">الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $row)
                        <tr>
                            <td>{{ optional($row->visit_date)->format('Y-m-d') ?? $row->visit_date }}</td>
                            <td>{{ optional($row->patient?->user)->name ?? '-' }}</td>
                            <td>{{ $row->service?->name ?? '-' }}</td>
                            <td>{{ number_format((float) $row->price, 2) }} ج.م</td>
                            <td>{!! $row->status_badge ?? '-' !!}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-muted">لا توجد بيانات للفترة المحددة</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div class="card-footer text-end fw-bold print-area">
            إجمالي الإيرادات: <span class="amount green">{{ number_format((float) $totalAmount, 2) }} ج.م</span>
        </div>
        <div class="mt-3 d-flex justify-content-center">
            {{ $rows->links() }}
        </div>
    </div>

</div>