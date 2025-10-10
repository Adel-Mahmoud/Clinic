@extends('layouts.master',['titlePage'=>$titlePage])
<x-page-header :titlePage="$titlePage" />

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">قائمة الأدوية</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table text-md-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الاسم العلمي</th>
                        <th>الشكل</th>
                        <th>التركيز</th>
                        <th>الشركة المصنعة</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($drugs as $drug)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $drug->name }}</td>
                        <td>{{ $drug->generic_name ?? '-' }}</td>
                        <td>{{ $drug->form ?? '-' }}</td>
                        <td>{{ $drug->strength ?? '-' }}</td>
                        <td>{{ $drug->manufacturer ?? '-' }}</td>
                        <td>
                            @if($drug->is_active)
                                <span class="badge bg-success">نشط</span>
                            @else
                                <span class="badge bg-danger">غير نشط</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-pills fa-2x text-muted mb-2"></i>
                            <br>
                            لا يوجد أدوية
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
