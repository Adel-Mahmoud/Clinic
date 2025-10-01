@extends('layouts.master',['titlePage'=>$titlePage])
<x-page-header :sectionPage="$sectionPage" :titlePage="$titlePage" />

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم الدور</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $role->name) }}" required>
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">الصلاحيات</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                            value="{{ $permission->name }}" id="perm_{{ $permission->id }}"
                                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">تحديث الدور</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection