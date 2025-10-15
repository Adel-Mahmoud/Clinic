@extends('layouts.master')
<x-page-header titlePage="الرئيسية" />

@section('css')
<!--  Owl-carousel css-->
<!-- <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet"> -->


<link href="{{URL::asset('assets/plugins/morris.js/morris.css')}}" rel="stylesheet">
@endsection
@section('content')

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
    <div class="col-md-8">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label mg-b-5">الإيرادات الأسبوعية</div>
                <p class="mg-b-20">إحصائيات الإيرادات والزيارات خلال الأيام السبعة الماضية</p>
                <div class="card">
                    <div class="card-body">
                        <div class="ht-200 ht-sm-300" id="flotBar1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mg-b-20 mg-md-b-0">
            <div class="card-body">
                <div class="main-content-label mg-b-5">توزيع الحجوزات</div>
                <p class="mg-b-20">نسبة الحجوزات حسب الحالة</p>
                <div class="card">
                    <div class="card-body">
                        <div class="ht-200 ht-sm-300" id="flotPie1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->

<!-- <div class="row">
    <div class="text-center">
        <img src="{{ config('settings.brand_image') ? asset('storage/' . config('settings.brand_image')) : URL::asset('assets/img/media/login.png') }}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="الخلفية">
    </div>
</div> -->
@endsection
@section('js')
<!-- Internal Flot js -->
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<!-- Internal Chart flot js -->
<!-- <script src="{{URL::asset('assets/js/chart.flot.js')}}"></script> -->
<!--Internal Chartjs js -->

<script>
    $(function() {
        const salesChartData = @json($chartData);
        const reservationsData = @json($reservationsDistribution);

        const barLabels = salesChartData.map(item => item.date);
        const barRevenue = salesChartData.map(item => Number(item.total_revenue) || 0);
        const barVisits = salesChartData.map(item => Number(item.visits_count) || 0);

        const plot = $.plot("#flotBar1", [], {
            grid: {
                borderWidth: 1,
                borderColor: "rgba(171,167,167,0.2)",
                hoverable: true,
                backgroundColor: {
                    colors: ["#ffffff", "#f8f9fa"]
                }
            },
            legend: {
                show: true,
                backgroundOpacity: 0
            },
            xaxis: {
                ticks: barLabels.map((label, i) => [i, label]),
                color: "rgba(171,167,167,0.2)"
            },
            yaxes: [{
                    position: 'left',
                    min: 0,
                    color: "rgba(171,167,167,0.2)"
                },
                {
                    position: 'right',
                    min: 0,
                    color: "rgba(171,167,167,0.2)"
                }
            ]
        });

        let step = 0;
        const steps = 40;

        function animateBars() {
            const currentRevenue = barRevenue.map(y => (y / steps) * step);
            const currentVisits = barVisits.map(y => (y / steps) * step);

            const data = [{
                    data: currentRevenue.map((y, i) => [i - 0.15, y]),
                    bars: {
                        show: true,
                        barWidth: 0.3,
                        align: "center",
                        fillColor: "#00c9a7"
                    },
                    color: "#00c9a7",
                    label: "الإيرادات (ج.م)",
                    yaxis: 1
                },
                {
                    data: currentVisits.map((y, i) => [i + 0.15, y]),
                    bars: {
                        show: true,
                        barWidth: 0.3,
                        align: "center",
                        fillColor: "#1e90ff"
                    },
                    color: "#1e90ff",
                    label: "عدد الزيارات",
                    yaxis: 2
                }
            ];

            plot.setData(data);
            plot.setupGrid();
            plot.draw();

            if (step < steps) {
                step++;
                setTimeout(animateBars, 20);
            }
        }

        animateBars();

        $("<div id='tooltip'></div>").css({
            position: "absolute",
            display: "none",
            padding: "6px 10px",
            "background-color": "#000",
            color: "#fff",
            opacity: 0.85,
            "border-radius": "4px",
            "font-size": "13px",
            "font-weight": "500"
        }).appendTo("body");

        $("#flotBar1").bind("plothover", function(event, pos, item) {
            if (item) {
                const value = item.datapoint[1];
                const label = item.series.label;
                $("#tooltip")
                    .html(`${label}: ${value}`)
                    .css({
                        top: item.pageY - 35,
                        left: item.pageX + 5
                    })
                    .fadeIn(200);
            } else {
                $("#tooltip").hide();
            }
        });

        const pieData = Object.entries(reservationsData).map(([label, value]) => ({
            label: label,
            data: value
        }));

        function labelFormatter(label, series) {
            return `<div style="font-size:12px;text-align:center;padding:2px;color:white;">${label}<br>${Math.round(series.percent)}%</div>`;
        }

        $.plot("#flotPie1", pieData, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 2 / 3,
                        formatter: labelFormatter,
                        threshold: 0.1
                    }
                }
            },
            legend: {
                show: false
            },
            grid: {
                hoverable: true,
                clickable: true
            },
            colors: ["#2299dd", "#f76a2d", "#ff9f43", "#ea5455"]
        });

        $("#flotPie1").bind("plothover", function(event, pos, obj) {
            if (!obj) return;
            const percent = parseFloat(obj.series.percent).toFixed(2);
            $("#tooltip")
                .html(`${obj.series.label}: ${percent}%`)
                .css({
                    top: pos.pageY + 5,
                    left: pos.pageX + 5
                })
                .fadeIn(200);
        });
    });
</script>
@endsection