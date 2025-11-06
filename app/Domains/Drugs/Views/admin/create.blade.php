@extends('layouts.master',['titlePage'=>$titlePage])
<x-page-header :sectionPage="$sectionPage" :titlePage="$titlePage" />

@section('css')
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
@endsection
@section('content')
<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0">استيراد الأدوية من ملف Excel</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.drugs.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <div class="custom-file">
                    <input class="dropify" data-height="150" name="file" type="file" accept=".xlsx,.xls,.csv" required>
                    @error('file') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-success submit d-inline-flex align-items-center gap-3">
                <i class="fas fa-file-excel"></i> استيراد الآن
            </button>
        </form>
    </div>
</div>
<x-form
    :action="route('admin.drugs.store')"
    submitLabel="إضافة دواء جديد"
    cancelRoute="admin.drugs.index">
    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">اسم الدواء <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">الاسم العلمي</label>
            <input type="text" name="generic_name" class="form-control" value="{{ old('generic_name') }}">
            @error('generic_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">الشكل</label>
            <select name="form" class="form-control">
                <option value="">اختر الشكل</option>
                <option value="أقراص" {{ old('form') == 'أقراص' ? 'selected' : '' }}>أقراص</option>
                <option value="كبسولات" {{ old('form') == 'كبسولات' ? 'selected' : '' }}>كبسولات</option>
                <option value="شراب" {{ old('form') == 'شراب' ? 'selected' : '' }}>شراب</option>
                <option value="حقن" {{ old('form') == 'حقن' ? 'selected' : '' }}>حقن</option>
                <option value="كريم" {{ old('form') == 'كريم' ? 'selected' : '' }}>كريم</option>
                <option value="مرهم" {{ old('form') == 'مرهم' ? 'selected' : '' }}>مرهم</option>
                <option value="قطرات" {{ old('form') == 'قطرات' ? 'selected' : '' }}>قطرات</option>
                <option value="بخاخ" {{ old('form') == 'بخاخ' ? 'selected' : '' }}>بخاخ</option>
            </select>
            @error('form') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">التركيز</label>
            <input type="text" name="strength" class="form-control" value="{{ old('strength') }}" placeholder="مثال: 500mg">
            @error('strength') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">الشركة المصنعة</label>
            <input type="text" name="manufacturer" class="form-control" value="{{ old('manufacturer') }}">
            @error('manufacturer') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">الباركود</label>
            <input type="text" name="barcode" class="form-control" value="{{ old('barcode') }}">
            @error('barcode') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">الجرعة الافتراضية</label>
            <input type="text" name="default_dosage" class="form-control" value="{{ old('default_dosage') }}" placeholder="مثال: قرص واحد مرتين يومياً">
            @error('default_dosage') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">التعليمات الافتراضية</label>
            <input type="text" name="default_instructions" class="form-control" value="{{ old('default_instructions') }}" placeholder="مثال: يؤخذ مع الطعام">
            @error('default_instructions') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">الحالة</label>
            <select name="is_active" class="form-control">
                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>نشط</option>
                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>غير نشط</option>
            </select>
            @error('is_active') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

    </div>
</x-form>
@endsection

@section('js')
<script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
@endsection