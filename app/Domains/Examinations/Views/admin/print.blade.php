<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>روشتة طبية - العيادة</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f5f5f5;
            padding: 10px;
            font-size: 14px;
        }

        .prescription-container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border: 1px solid #2c7fb8;
            position: relative;
            page-break-after: avoid;
        }

        /* Header Compact */
        .prescription-header {
            background: #2c7fb8;
            color: white;
            padding: 15px 20px;
            border-bottom: 2px solid #1c5a87;
        }

        .clinic-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .clinic-details {
            text-align: center;
            flex: 1;
        }

        .clinic-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .clinic-specialty {
            font-size: 13px;
            opacity: 0.9;
        }

        .clinic-contact {
            font-size: 12px;
            text-align: left;
        }

        /* Patient Info Compact */
        .info-section {
            padding: 15px 20px;
            background: #f8f9fa;
            border-bottom: 1px dashed #ccc;
        }

        .patient-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
        }

        .info-label {
            font-weight: bold;
            color: #555;
            font-size: 13px;
        }

        .info-value {
            color: #333;
            font-size: 13px;
        }

        /* Medications Compact */
        .medications-section {
            padding: 15px 20px;
        }

        .section-title {
            color: #2c7fb8;
            font-size: 16px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #2c7fb8;
        }

        .medications-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .medications-table th {
            background: #e3f2fd;
            color: #2c7fb8;
            padding: 8px 10px;
            text-align: right;
            font-weight: bold;
            border: 1px solid #b8daff;
        }

        .medications-table td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            text-align: right;
            line-height: 1.3;
        }

        .medications-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        /* Footer Compact */
        .prescription-footer {
            padding: 12px 20px;
            background: #2c7fb8;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
        }

        .doctor-signature {
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid white;
            padding-top: 3px;
            margin-top: 3px;
            width: 120px;
        }

        /* Print Optimization */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
                font-size: 12px;
            }

            .prescription-container {
                box-shadow: none;
                border: 1px solid #000;
                max-width: 100%;
                margin: 0;
                page-break-inside: avoid;
            }

            .no-print {
                display: none !important;
            }

            .prescription-header {
                background: #2c7fb8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .medications-table th {
                background: #e3f2fd !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .prescription-footer {
                background: #2c7fb8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            /* تجنب قطع الجداول بين الصفحات */
            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }

        /* Action Buttons Compact */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 15px 0;
            flex-wrap: wrap;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-print {
            background: #28a745;
            color: white;
        }

        .btn-print:hover {
            background: #218838;
        }

        .btn-save {
            background: #17a2b8;
            color: white;
        }

        .btn-save:hover {
            background: #138496;
        }

        /* Additional Info Section */
        .additional-info {
            padding: 10px 20px;
            background: #fff9e6;
            border-top: 1px dashed #ccc;
            font-size: 12px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .date-info {
            text-align: left;
            font-size: 11px;
            color: #666;
        }

        /* Compact Layout for more medications */
        .compact-row {
            font-size: 11px;
        }

        .compact-row td {
            padding: 4px 6px;
        }
    </style>
</head>

<body>
    <div class="action-buttons no-print">
        <button class="btn btn-print" onclick="window.print()">
            🖨️ طباعة الروشتة
        </button>
        <button onclick="window.history.back()" class="btn btn-save">
            رجوع
        </button>
        <!-- 
        <button class="btn btn-save" onclick="savePrescription()">
            💾 حفظ كـ PDF
        </button> -->
    </div>

    <div class="prescription-container" id="prescription">
        <!-- Header -->
        <div class="prescription-header">
            <div class="clinic-info">
                <div class="clinic-details">
                    <div class="clinic-name">عيادة الدكتور أحمد محمد</div>
                    <div class="clinic-specialty">استشاري الباطنة والجهاز الهضمي</div>
                </div>
                <div class="clinic-contact">
                    <div>📞 0123456789</div>
                    <div>📍 الرياض - الملك فهد</div>
                </div>
            </div>
        </div>

        <!-- Patient Information -->
        <div class="info-section">
            <div class="patient-info">
                <div class="info-item">
                    <span class="info-label">اسم المريض:</span>
                    <span class="info-value" id="patient-name">{{ $visit->visit->patient->user->name ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">العمر:</span>
                    <span class="info-value" id="patient-age">{{ \Carbon\Carbon::parse($visit->visit->patient->birth_date)->age  ?? 'N/A' }} سنة</span>
                </div>
                <div class="info-item">
                    <span class="info-label">التاريخ:</span>
                    <span class="info-value" id="prescription-date">{{ \Carbon\Carbon::parse($visit->visit->created_at)->format('d M')}}</span>
                </div>
                <!-- <div class="info-item">
                    <span class="info-label">رقم الملف:</span>
                    <span class="info-value" id="patient-file">M-2024-00123</span>
                </div> -->
            </div>
        </div>

        <!-- Medications -->
        <div class="medications-section">
            <div class="section-title">الأدوية الموصوفة</div>
            <table class="medications-table">
                <thead>
                    <tr>
                        <th width="25%">اسم الدواء</th>
                        <th width="20%">الجرعة / عدد المرات</th>
                        <th width="15%">المدة</th>
                        <th width="40%">التعليمات الخاصة</th>
                    </tr>
                </thead>

                <tbody id="medications-list">
                    @forelse ($visit->drugs as $drug)
                    <tr>
                        <td>{{ $drug->drug_name }}</td>
                        <td>{{ $drug->dose }}</td>
                        <td>{{ $drug->duration }}</td>
                        <td>{{ $drug->instructions }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">لا توجد أدوية مضافة في الروشتة</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <!-- Additional Information -->
        <div class="additional-info">
            <div class="info-grid">
                <div>
                    <strong>ملاحظات:</strong><br>
                    {{ $visit->notes }}
                    <!-- - تجنب الأطعمة الحارة والدهنية<br>
                    - تقسيم الوجبات إلى وجبات صغيرة -->
                </div>
                <!-- <div>
                    <strong>موعد المراجعة:</strong><br>
                    03/04/2024 - بعد أسبوعين
                </div> -->
            </div>
        </div>

        <!-- Footer -->
        <div class="prescription-footer">
            <div class="doctor-signature">
                <div>توقيع الطبيب</div>
                <div class="signature-line">د. أحمد محمد</div>
            </div>
            <div class="date-info">
                تم الإنشاء: <span id="creation-time">20/03/2024 10:30 ص</span>
            </div>
            <div>
                📞 0123456789<br>
                للطوارئ: 0501234567
            </div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>