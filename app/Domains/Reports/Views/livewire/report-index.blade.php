<div class="container py-4">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-3">
                    <label class="form-label">نوع الخدمة</label>
                    <select class="form-control" id="servesType">
                        <option value="" selected>كل الخدمات</option>
                        @foreach($getAllServices as $serves)
                            <option value="{{ $serves->id }}">{{ $serves->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">الفترة</label>
                    <select class="form-control" id="period">
                        <option value="daily">يومي</option>
                        <option value="weekly">أسبوعي</option>
                        <option value="monthly" selected>شهري</option>
                        <option value="quarterly">ربع سنوي</option>
                        <option value="yearly">سنوي</option>
                        <option value="custom">مخصص</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">من تاريخ</label>
                    <input type="date" class="form-control" id="startDate">
                </div>

                <div class="col-md-2">
                    <label class="form-label">إلى تاريخ</label>
                    <input type="date" class="form-control" id="endDate">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100" id="generateReport">
                        <i class="fas fa-chart-bar me-2"></i>توليد التقرير
                    </button>
                </div>

            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header">نتائج التقرير</div>
        <div class="card-body p-0">

            <div class="table-responsive">
            <table class="table table-hover text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th>التاريخ</th>
                        <th>المريض</th>
                        <th>الخدمة</th>
                        <th>السعر</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody id="reportTable">
                </tbody>
            </table>
            </div>

        </div>

        <div class="card-footer text-end fw-bold">
            إجمالي الإيرادات: <span id="totalAmount" class="amount green">0.00 ج.م</span>
        </div>
    </div>

</div>