@extends('layouts.master',['titlePage'=>$titlePage])
<x-page-header :sectionPage="$sectionPage" :titlePage="$titlePage" />

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">الاسم</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">كلمة المرور (اتركها فارغة إذا لا تريد التغيير)</label>
                            <input type="password" name="password" class="form-control">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">الأدوار</label>
                            <select name="roles[]" class="form-control" multiple required>
                                @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                    @if(isset($user) && $user->roles->pluck('name')->contains($role->name))
                                    selected
                                    @elseif(is_array(old('roles')) && in_array($role->name, old('roles')))
                                    selected
                                    @endif
                                    >
                                    {{ $role->name }}
                                </option>
                                @endforeach
                            </select>

                            @error('roles') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">تحديث</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">إلغاء</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection