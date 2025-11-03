@extends('layouts.master')
<x-page-header titlePage="الرئيسية" />

@section('css')
<link href="{{URL::asset('assets/plugins/morris.js/morris.css')}}" rel="stylesheet">
<style>
    .chart-container {
        position: relative;
        height: 300px;
    }

    .chart-legend {
        margin-top: 15px;
        text-align: center;
    }

    .legend-item {
        display: inline-block;
        margin: 0 10px;
        font-size: 12px;
    }

    .legend-color {
        display: inline-block;
        width: 12px;
        height: 12px;
        margin-right: 5px;
        border-radius: 2px;
    }

    .flot-chart {
        width: 100%;
        height: 100%;
    }
</style>
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
    <div class="col-12 col-xl-8">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <i class="fas fa-chart-line me-2"></i>الإيرادات والزيارات الأسبوعية
                </div>
                <p class="mg-b-20"> الإيرادات والزيارات خلال الأيام السبعة الماضية</p>
                <div class="chart-container">
                    <div id="flotBar1" class="flot-chart"></div>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: #00c9a7;"></span>
                        <span>الإيرادات (ج.م)</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: #1e90ff;"></span>
                        <span>عدد الزيارات</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-4">
        <div class="card mg-b-20 mg-md-b-0">
            <div class="card-body">
                <div class="text-center mb-2">
                    <div class="main-content-label d-inline-block">
                        <i class="fas fa-chart-pie me-2"></i> حجوزات اليوم
                        <span class="text-muted"> | نسبة الحجوزات  </span>
                    </div>
                </div>

                <div class="text-center mb-2 d-flex">
                    @foreach($reservationsDistribution as $label => $data)
                        <div class="legend-item mb-1 d-inline-flex align-items-center">
                            <span class="legend-color me-2" style="background-color: {{ $loop->index == 0 ? '#2299dd' : ($loop->index == 1 ? '#f76a2d' : ($loop->index == 2 ? '#ff9f43' : '#ea5455')) }};"></span>
                            <span>{{ $label }}</span>
                        </div><br>
                    @endforeach
                </div>
                <div class="chart-container">
                    <div id="flotPie1" class="flot-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection

@section('js')
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>

<script>
    $(function() {
        'use strict';

        const salesChartData = @json($chartData);
        const reservationsData = @json($reservationsDistribution);

        // تحضير بيانات الرسم البياني الشريطي
        const barLabels = salesChartData.map(item => item.formatted_date);
        const barRevenue = salesChartData.map(item => Number(item.total_revenue) || 0);
        const barVisits = salesChartData.map(item => Number(item.visits_count) || 0);

        // إعداد الرسم البياني الشريطي
        const barData = [{
                data: barRevenue.map((y, i) => [i, y]),
                bars: {
                    show: true,
                    barWidth: 0.3,
                    align: "center",
                    fill: true,
                    lineWidth: 1
                },
                color: "#00c9a7",
                label: "الإيرادات (ج.م)"
            },
            {
                data: barVisits.map((y, i) => [i, y]),
                bars: {
                    show: true,
                    barWidth: 0.3,
                    align: "center",
                    fill: true,
                    lineWidth: 1
                },
                color: "#1e90ff",
                label: "عدد الزيارات"
            }
        ];

        const barOptions = {
            grid: {
                borderWidth: 1,
                borderColor: "rgba(171,167,167,0.2)",
                hoverable: true,
                backgroundColor: "#fff"
            },
            xaxis: {
                ticks: barLabels.map((label, i) => [i, label]),
                color: "rgba(171,167,167,0.8)",
                font: {
                    size: 11
                }
            },
            yaxis: {
                color: "rgba(171,167,167,0.8)",
                min: 0,
                tickFormatter: function(val) {
                    return val.toLocaleString();
                }
            }
        };

        $.plot("#flotBar1", barData, barOptions);

        // إعداد الرسم البياني الدائري
        // const pieColors = ["#2299dd", "#f76a2d", "#ff9f43", "#ea5455"];
        const pieColorsMap = {
            "قيد الانتظار": "#ff9f43", // أصفر
            "مؤكدة": "#28c76f", // أخضر (مثال)
            "ملغاة": "#ea5455", // أحمر (مثال)
            "مكتملة": "#2299dd" // ازرق
        };
        const pieData = [];
        Object.entries(reservationsData).forEach(([label, data]) => {
            if (data.count > 0) {
                pieData.push({
                    label: label,
                    data: [
                        [label, data.count]
                    ],
                    color: pieColorsMap[label] ?? "#888" // لون افتراضي إذا لم يوجد
                });
            }
        });

        const pieOptions = {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 0.6,
                        formatter: function(label, series) {
                            return '<div style="font-size:11px;text-align:center;padding:2px;color:white;font-weight:600;">' +
                                Math.round(series.percent) + '%</div>';
                        },
                        background: {
                            opacity: 0.8
                        },
                        threshold: 0.05
                    }
                }
            },
            grid: {
                hoverable: true,
                clickable: true
            },
            legend: {
                show: false
            }
        };

        // التأكد من وجود بيانات للرسم البياني الدائري
        if (pieData.length > 0) {
            $.plot("#flotPie1", pieData, pieOptions);
        } else {
            $("#flotPie1").html('<div class="text-center p-5"><i class="fas fa-chart-pie fa-3x text-muted mb-3"></i><p>لا توجد بيانات للعرض</p></div>');
        }

        // تحسين التلميحات
        $("<div id='tooltip'></div>").css({
            position: "absolute",
            display: "none",
            padding: "8px 12px",
            "background-color": "rgba(0,0,0,0.8)",
            color: "#fff",
            "border-radius": "6px",
            "font-size": "12px",
            "font-weight": "500",
            "z-index": "1000",
            "box-shadow": "0 2px 10px rgba(0,0,0,0.2)"
        }).appendTo("body");

        // إضافة تفاعل التلميحات للرسم البياني الشريطي
        $("#flotBar1").bind("plothover", function(event, pos, item) {
            if (item) {
                let tooltipText = '';
                if (item.seriesIndex === 0) {
                    tooltipText = `الإيرادات: ${Number(item.datapoint[1]).toLocaleString()} ج.م<br>التاريخ: ${barLabels[item.dataIndex]}`;
                } else {
                    tooltipText = `الزيارات: ${Number(item.datapoint[1]).toLocaleString()} زيارة<br>التاريخ: ${barLabels[item.dataIndex]}`;
                }

                $("#tooltip")
                    .html(tooltipText)
                    .css({
                        top: item.pageY - 45,
                        left: item.pageX + 10
                    })
                    .fadeIn(200);
            } else {
                $("#tooltip").hide();
            }
        });

        // إضافة تفاعل التلميحات للرسم البياني الدائري
        $("#flotPie1").bind("plothover", function(event, pos, obj) {
            if (!obj) {
                $("#tooltip").hide();
                return;
            }

            const percent = parseFloat(obj.series.percent).toFixed(1);
            $("#tooltip")
                .html(`${obj.series.label}<br>النسبة: ${percent}%<br>العدد: ${obj.series.data[0][1]}`)
                .css({
                    top: pos.pageY - 45,
                    left: pos.pageX + 10
                })
                .fadeIn(200);
        });

        // إخفاء التلميحات عند مغادرة المنطقة
        $(".chart-container").mouseleave(function() {
            $("#tooltip").fadeOut(200);
        });

        // إعادة رسم الرسوم البيانية عند تغيير حجم النافذة
        $(window).resize(function() {
            $.plot("#flotBar1", barData, barOptions);
            if (pieData.length > 0) {
                $.plot("#flotPie1", pieData, pieOptions);
            }
        });
    });
</script>
@endsection