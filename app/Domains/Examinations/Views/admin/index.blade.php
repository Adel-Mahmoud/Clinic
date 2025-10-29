@extends('layouts.master', ['titlePage' => $titlePage ?? 'الكشف'])
<x-page-header :titlePage="$titlePage ?? 'الكشف'" />

@section('css')
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/css/examination.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="container-fluid p-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fe fe-user-check me-1"></i>
                نوع الخدمة :
                {{ $nextVisit->service->name }}
            </h5>
            <small>تاريخ آخر زيارة: {{ now()->format('Y-m-d') }}</small>
        </div>

        <div class="card-body">
            <div class="patient-info-card mb-4">
                <div class="patient-info-header"><i class="fe fe-user fs-5"></i><span>بيانات المريض</span></div>
                <div class="patient-info-grid">
                    <div class="patient-info-item"><span class="patient-info-label">الاسم:</span><span class="patient-info-value">{{ $nextVisit->patient->user->name }}</span></div>
                    <div class="patient-info-item"><span class="patient-info-label">العمر:</span><span class="patient-info-value">{{ \Carbon\Carbon::parse($nextVisit->patient->birth_date)->age }} سنة</span></div>
                    <div class="patient-info-item"><span class="patient-info-label">الجنس:</span><span class="patient-info-value">{{ $nextVisit->patient->gender == 'male' ? 'ذكر' : 'أنثى' }}</span></div>
                    <div class="patient-info-item"><span class="patient-info-label">الحالة الصحية العامة:</span><span class="patient-info-value">{{ $nextVisit->patient->general_health_status }}</span></div>
                    <div class="patient-info-item"><span class="patient-info-label">حساسية الأدوية:</span><span class="patient-info-value">{{ $nextVisit->patient->drug_allergy ?? 'غير محدد' }}</span></div>
                </div>
            </div>

            <form id="diagnosisForm" action="{{ route('admin.examinations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="visit_id" value="{{ $nextVisit->id }}">
                <div class="form-section">
                    <h6 class="form-section-title"><i class="fe fe-activity me-2"></i> التشخيص الطبي</h6>
                    <div class="row g-4">
                        <div class="col-md-6"><label class="form-label fw-semibold">الأعراض</label><textarea class="form-control" rows="4" placeholder="وصف الأعراض..." required></textarea></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">التشخيص</label><textarea class="form-control" rows="4" placeholder="نتيجة التشخيص..." required></textarea></div>
                    </div>
                </div>

                <div class="form-section">
                    <h6 class="form-section-title"><i class="fe fe-package me-2"></i> الروشتة الطبية</h6>
                    <div class="row g-3">
                        <div class="col-md-8 position-relative">
                            <label class="form-label fw-semibold">إضافة دواء</label>
                            <div class="input-group">
                                <input type="text" id="drugInput" class="form-control" placeholder="اكتب اسم الدواء...">
                                <button type="button" id="addDrug" class="btn btn-primary"><i class="fe fe-plus"></i></button>
                            </div>
                            <div id="suggestions" class="suggestions d-none"></div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div id="drugList" class="row g-2"></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center d-none" id="drugTable">
                                <thead class="table-primary">
                                    <tr>
                                        <th>اسم الدواء</th>
                                        <th>الجرعة</th>
                                        <th>المدة</th>
                                        <th>الشكل</th>
                                        <th>تعليمات</th>
                                        <th style="width: 60px">حذف</th>
                                    </tr>
                                </thead>
                                <tbody id="drugRows"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h6 class="form-section-title"><i class="fe fe-sliders me-2"></i> التحاليل والأشعة المطلوبة</h6>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">نوع الفحص</label>
                            <div class="d-flex flex-column gap-2">
                                <label class="test-type-label"><input type="radio" name="testType" value="lab"> تحاليل</label>
                                <label class="test-type-label"><input type="radio" name="testType" value="xray"> أشعة</label>
                                <label class="test-type-label"><input type="radio" name="testType" value="both"> كلاهما</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">تفاصيل الفحص</label>
                            <textarea class="form-control" rows="3" placeholder="تفاصيل الفحوص المطلوبة..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h6 class="form-section-title"><i class="fe fe-edit me-2"></i> ملاحظات إضافية</h6>
                    <textarea class="form-control" rows="3" placeholder="ملاحظات إضافية..."></textarea>
                </div>

                <div class="form-section">
                    <h6 class="form-section-title"><i class="fe fe-paperclip me-2"></i> المرفقات</h6>
                    <input type="file" class="dropify" data-height="150" name="attachments[]" multiple>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg submit px-5"><i class="fe fe-save me-2"></i> حفظ الكشف</button>
                </div>
            </form>

            <div class="form-section mt-4">
                <h6 class="form-section-title"><i class="fe fe-clock me-2"></i> سجل الزيارات السابقة</h6>
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
                            <tr>
                                <td>1</td>
                                <td>2025-10-28</td>
                                <td><span class="badge bg-primary">كشف عادي</span></td>
                                <td>صداع، حرارة</td>
                                <td>نزلة برد</td>
                                <td><button class="btn btn-outline-primary btn-sm"><i class="fe fe-eye"></i></button></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>2025-10-20</td>
                                <td><span class="badge bg-success">متابعة</span></td>
                                <td>آلام معدة</td>
                                <td>التهاب معدة</td>
                                <td><button class="btn btn-outline-primary btn-sm"><i class="fe fe-eye"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('diagnosisForm');
        const button = form?.querySelector('.submit');
        const input = document.getElementById('drugInput');
        const addDrugBtn = document.getElementById('addDrug');
        const drugList = document.getElementById('drugList');
        const suggestionsBox = document.getElementById('suggestions');
        const allDrugs = @json($drugs->pluck('name'));

        document.querySelectorAll('.test-type-label').forEach(label => {
            label.addEventListener('click', () => {
                document.querySelectorAll('.test-type-label').forEach(l => l.classList.remove('active'));
                label.classList.add('active');
            });
        });

        let suggestionIndex = -1; 

        input?.addEventListener('input', () => {
            const q = input.value.trim().toLowerCase();
            suggestionsBox.innerHTML = '';
            suggestionIndex = -1;

            if (!q) return suggestionsBox.classList.add('d-none');

            const matches = allDrugs.filter(d => d.toLowerCase().includes(q));
            if (!matches.length) return suggestionsBox.classList.add('d-none');

            suggestionsBox.classList.remove('d-none');

            matches.forEach((drug, index) => {
                const div = document.createElement('div');
                div.className = 'suggestion-item';
                div.textContent = drug;
                div.dataset.index = index;

                div.onclick = () => {
                    suggestionsBox.classList.add('d-none');
                    addDrugToTable(drug);
                    input.value = '';
                };

                suggestionsBox.appendChild(div);
            });
        });

        input?.addEventListener('keydown', (e) => {

            const items = suggestionsBox.querySelectorAll('.suggestion-item');

            // ↓ Down Arrow
            if (e.key === 'ArrowDown' && items.length) {
                e.preventDefault();
                suggestionIndex = (suggestionIndex + 1) % items.length;
            }

            // ↑ Up Arrow
            if (e.key === 'ArrowUp' && items.length) {
                e.preventDefault();
                suggestionIndex = (suggestionIndex - 1 + items.length) % items.length;
            }

            items.forEach((el, idx) => {
                el.classList.toggle('active', idx === suggestionIndex);
            });

            if (e.key === 'Tab' && items.length) {
                e.preventDefault();
                suggestionIndex = 0;
                items[0].classList.add('active');
            }

            if (e.key === 'Enter' && suggestionIndex >= 0) {
                e.preventDefault();
                const selectedDrug = items[suggestionIndex].textContent.trim();
                addDrugToTable(selectedDrug);
                input.value = '';
                suggestionsBox.classList.add('d-none');
                suggestionIndex = -1;
            }
        });

        function addDrugToForm(drug) {
            const normalizedDrug = drug.trim();

            if (!normalizedDrug) return;

            const exists = Array.from(drugList.querySelectorAll('.drug-item span'))
                .some(el => el.textContent.trim() === normalizedDrug);

            if (exists) {
                alert('هذا الدواء مضاف مسبقًا!');
                return;
            }

            const id = 'drug-' + Date.now();
            drugList.insertAdjacentHTML('beforeend', `
                <div class="col-md-6" id="${id}">
                    <div class="drug-item">
                        <span>${normalizedDrug}</span>
                        <button type="button" class="btn btn-sm btn-danger" onclick="document.getElementById('${id}').remove()">
                            <i class="fe fe-trash-2"></i>
                        </button>
                    </div>
                </div>
            `);
        }

        function addDrugToTable(drug) {
            document.getElementById('drugTable').classList.remove('d-none');
            const normalizedDrug = drug.trim();
            if (!normalizedDrug) return;

            const exists = Array.from(document.querySelectorAll('#drugRows tr td:first-child'))
                .some(el => el.textContent.trim() === normalizedDrug);

            if (exists) {
                alert('هذا الدواء مضاف مسبقًا!');
                return;
            }

            const id = 'drug-' + Date.now();

            const row = `
                <tr id="${id}">
                    <td>${normalizedDrug}<input type="hidden" name="drugs[${id}][name]" value="${normalizedDrug}"></td>
                    <td><input type="text" class="form-control" name="drugs[${id}][dose]" placeholder="مثل قرص واحد مرتين يومياً"></td>
                    <td><input type="text" class="form-control" name="drugs[${id}][duration]" placeholder="مثال: 5 أيام"></td>
                    <td>
                        <select class="form-control" name="drugs[${id}][form]">
                            <option value="">اختر...</option>
                            <option value="tablet">قرص</option>
                            <option value="syrup">شراب</option>
                            <option value="injection">حقنة</option>
                            <option value="capsule">كبسولة</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="drugs[${id}][instructions]" placeholder="تعليمات الاستخدام"></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger" onclick="document.getElementById('${id}').remove()">
                            <i class="fe fe-trash-2"></i>
                        </button>
                    </td>
                </tr>
            `;

            document.getElementById('drugRows').insertAdjacentHTML('beforeend', row);
        }

        addDrugBtn?.addEventListener('click', () => {
            const drug = input.value.trim();
            if (!drug) return;
            addDrugToTable(drug);
            input.value = '';
            suggestionsBox.classList.add('d-none');
        });

        form?.addEventListener('submit', e => {
            // e.preventDefault();
            if (!button) return;
            button.disabled = true;
            const original = button.innerHTML;
            button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> جاري الحفظ...';
            setTimeout(() => {
                button.innerHTML = original;
                button.disabled = false;
                Swal.fire({
                    icon: 'success',
                    title: 'تم الحفظ بنجاح',
                    showConfirmButton: false,
                    timer: 1500
                });
            }, 1200);
        });
    });
</script>
@endsection