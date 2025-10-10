@extends('layouts.master',['titlePage'=>$titlePage])
<x-page-header :sectionPage="$sectionPage" :titlePage="$titlePage" />

@section('content')
<x-form
    :action="route('admin.services.update', $service->id)"
    method="PUT"
    submitLabel="تحديث الخدمة"
    cancelRoute="admin.services.index">
    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">اسم الخدمة <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control"
                value="{{ old('name', $service->name) }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">السعر <span class="text-danger">*</span></label>
            <input type="number" name="price" class="form-control"
                value="{{ old('price', $service->price) }}" step="0.01" min="0" required>
            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">الوصف</label>
            <textarea name="description" class="form-control" rows="4" placeholder="وصف الخدمة">{{ old('description', $service->description) }}</textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">الحالة</label>
            <select name="is_active" class="form-control">
                <option value="1" {{ old('is_active', $service->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>نشط</option>
                <option value="0" {{ old('is_active', $service->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>غير نشط</option>
            </select>
            @error('is_active') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

    </div>
</x-form>
@endsection
