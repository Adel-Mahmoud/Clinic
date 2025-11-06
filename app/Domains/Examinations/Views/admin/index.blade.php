@extends('layouts.master', ['titlePage' => $titlePage ?? 'الكشف'])
<x-page-header :titlePage="$titlePage ?? 'الكشف'" />

@section('css')
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/css/examination.css') }}" rel="stylesheet" />
@endsection

@section('content')
@if ($errors->any())
@foreach ($errors->all() as $error)
<div class="alert alert-danger mb-2">
    {{ $error }}
</div>
@endforeach
@endif

@if(!$nowVisit)
    <div class="alert alert-light alert-dismissible fade show text-center fs-5 my-4 d-flex align-items-center justify-content-center">
        <i class="fas fa-calendar-times fa-2x me-3 mx-3"></i> 
        <div>
            <h5 class="alert-heading mb-2 text-info">لا توجد زيارة حالية</h5>
            <p class="mb-0 text-muted">لم يتم العثور على أي زيارة نشطة في الوقت الحالي</p>
        </div>
    </div>
@else
    <div class="container-fluid p-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fe fe-user-check me-1"></i>
                    نوع الخدمة :
                    {{ $nowVisit->service->name }}
                </h5>
                <small>تاريخ آخر زيارة: {{ $lastCompleted && $lastCompleted->visit_date ? $lastCompleted->visit_date->format('Y-m-d') : 'N/A' }}</small>
            </div>

            <div class="card-body">
                <div class="panel panel-primary tabs-style-2">
                    <div class="tab-menu-heading">
                        <div class="tabs-menu1">
                            <ul class="nav panel-tabs main-nav-line">
                                <li><a href="#tab_exam" class="nav-link active" data-toggle="tab">
                                        <i class="fe fe-clipboard me-2"></i> تفاصيل الكشف الحالي
                                    </a></li>
                
                                <li><a href="#tab_history" class="nav-link" data-toggle="tab">
                                        <i class="fe fe-clock me-2"></i> سجل الزيارات السابقة
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                
                    <div class="panel-body tabs-menu-body main-content-body-right border">
                        <div class="tab-content">
                
                            <div class="tab-pane active" id="tab_exam">
                                <div class="patient-info-card mb-4">
                                    <div class="patient-info-header"><i class="fe fe-user fs-5"></i><span>بيانات الحالة</span></div>
                                    <div class="patient-info-grid">
                                        <div class="patient-info-item"><span class="patient-info-label">الاسم:</span> <span class="patient-info-value">{{ $nowVisit->patient->user->name ?? 'N/A' }}</span></div>
                                        <div class="patient-info-item"><span class="patient-info-label">العمر:</span> <span class="patient-info-value">{{ \Carbon\Carbon::parse($nowVisit->patient->birth_date)->age  ?? 'N/A' }} سنة</span></div>
                                        <div class="patient-info-item"><span class="patient-info-label">الجنس:</span> <span class="patient-info-value">{{ $nowVisit->patient->gender == 'male' ? 'ذكر' : 'أنثى' }}</span></div>
                                        <div class="patient-info-item"><span class="patient-info-label">الحالة الصحية العامة:</span> <span class="patient-info-value">{{ $nowVisit->patient->general_health_status  ?? 'N/A' }}</span></div>
                                        <div class="patient-info-item"><span class="patient-info-label">حساسية الأدوية:</span> <span class="patient-info-value">{{ $nowVisit->patient->drug_allergy ?? 'N/A' }}</span></div>
                                    </div>
                                </div>
                
                                <form id="diagnosisForm" action="{{ route('admin.examinations.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="visit_id" value="{{ $nowVisit->id }}">
                                    <div class="form-section">
                                        <h6 class="form-section-title"><i class="fe fe-activity me-2"></i> التشخيص الطبي</h6>
                                        <div class="row g-4">
                                            <div class="col-md-6"><label class="form-label fw-semibold">الأعراض</label><textarea name="symptoms" class="form-control" rows="4" placeholder="وصف الأعراض..." required></textarea></div>
                                            <div class="col-md-6"><label class="form-label fw-semibold">التشخيص</label><textarea name="diagnosis" class="form-control" rows="4" placeholder="نتيجة التشخيص..." required></textarea></div>
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
                                                    <label class="test-type-label"><input type="radio" name="test_type" value="lab"> تحاليل</label>
                                                    <label class="test-type-label"><input type="radio" name="test_type" value="xray"> أشعة</label>
                                                    <label class="test-type-label"><input type="radio" name="test_type" value="both"> كلاهما</label>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label fw-semibold">تفاصيل الفحص</label>
                                                <textarea name="test_details" class="form-control" rows="3" placeholder="تفاصيل الفحوص المطلوبة..."></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-section">
                                                <h6 class="form-section-title"><i class="fe fe-edit me-2"></i> ملاحظات إضافية</h6>
                                                <textarea name="notes" class="form-control" rows="7" placeholder="ملاحظات إضافية..."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-section">
                                                <h6 class="form-section-title"><i class="fe fe-paperclip me-2"></i> المرفقات</h6>
                                                <input type="file" class="dropify" data-height="150" name="attachments[]" multiple>
                                            </div>
                                        </div>
                                    </div>
                
                
                                    <div class="text-center mt-4">
                                        @can('create examination')
                                        <button type="submit" class="m-auto btn btn-primary btn-lg submit px-5">
                                            <i class="fe fe-save me-2"></i> حفظ الكشف</button>
                                        @endcan
                                    </div>
                                </form>
                            </div>
                
                            <div class="tab-pane" id="tab_history">
                                @livewire('examinations.patient-visits', ['patientId' => $nowVisit->patient_id])
                            </div>
                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

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
    const allDrugs = @json($drugs->pluck('name'));
</script>
<script src="{{ URL::asset('assets/js/examination.js') }}"></script>
@endsection