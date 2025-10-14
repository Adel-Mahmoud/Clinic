@extends('layouts.master')
<x-page-header titlePage="الرئيسية" />

@section('css')
<!--  Owl-carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Maps css -->
<link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<!-- row -->
<div class="row row-sm">
    <x-stats-card
        title="المرضى الجدد اليوم"
        value="{{ $stats['new_patients_today'] }}"
        bg="bg-primary-gradient"
        chart-id="compositeline" />

    <x-stats-card
        title="الحجوزات المؤكدة"
        value="{{ $stats['confirmed_reservations'] }}"
        bg="bg-danger-gradient"
        chart-id="compositeline2" />

    <x-stats-card
        title="الحجوزات المنتظرة"
        value="{{ $stats['pending_reservations'] }}"
        bg="bg-success-gradient"
        chart-id="compositeline3" />

    <x-stats-card
        title="إيرادات اليوم"
        value="{{ number_format($stats['today_revenue'], 2) . ' ج.م' }}"
        bg="bg-warning-gradient"
        chart-id="compositeline4" />

</div>
<!-- row closed -->
<!-- row -->
<div class="card mt-4 p-3">
    <!-- row -->
    <div class="row row-sm mt-4">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">الإيرادات والزيارات خلال الأسبوع</h3>
                </div>
                <div class="card-body">
                    <div class="chart-wrapper">
                        <canvas id="chartStacked1" class="h-300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">توزيع الحجوزات</h3>
                </div>
                <div class="card-body">
                    <div class="chart-wrapper">
                        <canvas id="chartPie" class="h-300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الإحصائيات الإضافية -->
    <div class="row row-sm mt-4">
    <div class="col-lg-6 col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">آخر الحجوزات</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>المريض</th>
                                <th>التاريخ</th>
                                <th>الحالة</th>
                                <th>المبلغ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservationsDistribution as $visit)
                            <tr>
                                <td>{{ $visit->patient->name ?? 'غير محدد' }}</td>
                                <td>{{ $visit->visit_date->format('Y-m-d') }}</td>
                                <td>
                                    <span class="badge badge-{{ $visit->status == 'completed' ? 'success' : ($visit->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ $visit->status }}
                                    </span>
                                </td>
                                <td>{{ number_format($visit->price, 2) }} ج.م</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- ... -->
</div>
    <!-- /row -->
</div>

<div class="row">
    <div class="text-center">
        <img src="{{ config('settings.brand_image') ? asset('storage/' . config('settings.brand_image')) : URL::asset('assets/img/media/login.png') }}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="الخلفية">
    </div>
</div>
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>

<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!--Internal  Chart.bundle js -->
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal Chartjs js -->
<script>
    // charts initialization
    $(function() {
        'use strict';

        // Stacked Bar Chart
        var ctx1 = document.getElementById('chartStacked1').getContext('2d');
        var chartStacked1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
                datasets: [{
                    label: 'المرضى الجدد',
                    data: [65, 59, 80, 81, 56, 55],
                    backgroundColor: '#007bff'
                }, {
                    label: 'الحجوزات المؤكدة',
                    data: [28, 48, 40, 19, 86, 27],
                    backgroundColor: '#dc3545'
                }]
            },
            options: {
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        rtl: true
                    }
                }
            }
        });

        // Pie Chart
        var ctx2 = document.getElementById('chartPie').getContext('2d');
        var chartPie = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['حجوزات مؤكدة', 'حجوزات منتظرة', 'ملغية'],
                datasets: [{
                    data: [60, 25, 15],
                    backgroundColor: ['#007bff', '#28a745', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        rtl: true
                    }
                }
            }
        });
    });
</script>

@endsection