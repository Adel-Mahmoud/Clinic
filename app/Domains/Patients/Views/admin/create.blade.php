@extends('layouts.master',['titlePage'=>$titlePage])
<x-page-header :sectionPage="$sectionPage" :titlePage="$titlePage" />

@section('content')
<x-form
    :action="route('admin.patients.store')"
    submitLabel="اضافة مريض جديد"
    cancelRoute="admin.patients.index">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-user-lock me-2"></i>
                    <h5 class="mb-0 mr-1">بيانات تسجيل الدخول</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">الاسم</label>
                            <input type="text" name="user_name" class="form-control" value="{{ old('user_name') }}" required autofocus>
                            @error('user_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">البريد الإلكتروني</label>
                            <input type="email" name="user_email" class="form-control" value="{{ old('user_email') }}">
                            @error('user_email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">كلمة المرور</label>
                            <input type="password" name="user_password" class="form-control" >
                            @error('user_password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm border-success">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="fas fa-user-md me-2"></i>
                    <h5 class="mb-0 mr-1">بيانات المريض</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">الهاتف</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">الجنس</label>
                            <select name="gender" class="form-control">
                                <option value="">اختر</option>
                                <option value="male" @selected(old('gender')==='male' )>ذكر</option>
                                <option value="female" @selected(old('gender')==='female' )>أنثى</option>
                            </select>
                            @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">تاريخ الميلاد</label>
                            <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}">
                            @error('birth_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">العنوان</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">الرقم القومي</label>
                            <input type="text" name="national_id" class="form-control" value="{{ old('national_id') }}">
                            @error('national_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">الحالة الصحية العامة</label>
                            <textarea name="general_health_status" class="form-control" rows="3">{{ old('general_health_status') }}</textarea>
                            @error('general_health_status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">حساسية الأدوية</label>
                            <textarea name="drug_allergy" class="form-control" rows="3">{{ old('drug_allergy') }}</textarea>
                            @error('drug_allergy') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">ملاحظات إضافية</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                            @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-form>
@endsection