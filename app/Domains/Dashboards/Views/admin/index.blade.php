@extends('layouts.master')
<x-page-header titlePage="الرئيسية" />

@section('css')
<link href="{{URL::asset('assets/plugins/morris.js/morris.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/custom/css/dashboard.css')}}" rel="stylesheet">
@endsection

@section('content')
@can('view dashboard')
<!-- row -->
<div class="row row-sm">
    <x-stats-card
        title="المرضى الجدد اليوم"
        value="{{ $stats['new_patients_today'] }}"
        bg="bg-primary-gradient"
        icon="fas fa-user-injured" />

    <x-stats-card
        title="الحجوزات المؤكدة"
        value="{{ $stats['confirmed_reservations'] }}"
        bg="bg-info-gradient"
        icon="fas fa-calendar-check" />

    <x-stats-card
        title="الحجوزات المنتظرة"
        value="{{ $stats['pending_reservations'] }}"
        bg="bg-warning-gradient"
        icon="fe fe-pie-chart" />

    <x-stats-card
        title="إيرادات اليوم"
        value="{{ number_format($stats['today_revenue'], 2) . ' ج.م' }}"
        bg="bg-success-gradient"
        icon="fe fe-dollar-sign" />
</div>
<!-- row closed -->

<!-- row -->
<div class="row row-sm">
    <div class="col-12 col-xl-8">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <i class="fas fa-chart-line me-2"></i>
                    &nbsp;
                    الإيرادات والزيارات الأسبوعية
                </div>
                <p class="mg-b-20">إحصائيات الإيرادات والزيارات خلال الأيام السبعة الماضية</p>

                <div class="chart-container">
                    <div id="flotBar1" class="flot-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-4">
        <div class="card mg-b-20 mg-md-b-0">
            <div class="card-body">
                <div class="mb-2">
                    <div class="main-content-label mg-b-5">
                        <i class="fas fa-chart-pie me-2"></i>
                        &nbsp;
                        توزيع الحجوزات اليوم
                    </div>
                    <p class="mg-b-20">نسبة الحجوزات حسب الحالة</p>
                </div>

                <div class="chart-container">
                    <div id="flotPie1" class="flot-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- row closed -->
@else
<div class="card">
    <div class="card-body">
        <img src="{{ config('settings.brand_image') ? asset('storage/' . config('settings.brand_image')) : URL::asset('assets/img/media/login.png') }}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="شعار الدخول">
    </div>
</div>
@endcan
@endsection

@section('js')
<script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script>
    const salesChartData = @json($chartData);
    const reservationsData = @json($reservationsDistribution);
</script>
<script src="{{ asset('assets/custom/js/dashboard.js')}}"></script>
@endsection