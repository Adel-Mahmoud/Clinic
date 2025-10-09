@extends('layouts.master',['titlePage'=>$titlePage])
<x-page-header :sectionPage="$sectionPage" :titlePage="$titlePage" />

@section('content')
<x-form
    :action="route('admin.patients.update', $patient->id)"
    method="PUT"
    submitLabel="تحديث المريض"
    cancelRoute="admin.patients.index">
    <div class="row">

        <input type="hidden" name="user_id" value="{{ $patient->user_id }}">

        <div class="col-12">
            <h5 class="mb-3">بيانات تسجيل الدخول</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">الاسم</label>
                    <input type="text" name="user_name" class="form-control" value="{{ old('user_name', optional($patient->user)->name) }}" required>
                    @error('user_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="user_email" class="form-control" value="{{ old('user_email', optional($patient->user)->email) }}" required>
                    @error('user_email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">كلمة المرور (اتركها فارغة إذا لا تريد التغيير)</label>
                    <input type="password" name="user_password" class="form-control">
                    @error('user_password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <hr>
        </div>

        <div class="col-12">
            <h5 class="mb-3">بيانات المريض</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">الهاتف</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $patient->phone) }}">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">الجنس</label>
                    <select name="gender" class="form-control">
                        <option value="">اختر</option>
                        <option value="male" @selected(old('gender', $patient->gender)==='male')>ذكر</option>
                        <option value="female" @selected(old('gender', $patient->gender)==='female')>أنثى</option>
                    </select>
                    @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">تاريخ الميلاد</label>
                    <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $patient->birth_date ? \Illuminate\Support\Carbon::parse($patient->birth_date)->format('Y-m-d') : '') }}">
                    @error('birth_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">العنوان</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $patient->address) }}">
                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">الرقم القومي</label>
                    <input type="text" name="national_id" class="form-control" value="{{ old('national_id', $patient->national_id) }}">
                    @error('national_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

    </div>
</x-form>
@endsection

 
