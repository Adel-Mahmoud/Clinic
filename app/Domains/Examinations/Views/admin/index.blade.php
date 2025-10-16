@extends('layouts.master',['titlePage'=>$titlePage ?? 'الكشف'])
<x-page-header :titlePage="$titlePage ?? 'الكشف'" />

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- بيانات المريض -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">بيانات المريض</h5>
                </div>
                <div class="card-body">
                    <div class="patient-info">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar me-3">
                                <img src="{{ asset('assets/images/default-avatar.png') }}" alt="صورة المريض" class="rounded-circle" width="60">
                            </div>
                            <div>
                                <h6 class="mb-0">محمد أحمد</h6>
                                <small class="text-muted">رقم الملف: #12345</small>
                            </div>
                        </div>
                        
                        <div class="info-item mb-2">
                            <span class="fw-bold">العمر:</span> 32 سنة
                        </div>
                        <div class="info-item mb-2">
                            <span class="fw-bold">الجنس:</span> ذكر
                        </div>
                        <div class="info-item mb-2">
                            <span class="fw-bold">رقم الهاتف:</span> 0123456789
                        </div>
                        <div class="info-item mb-2">
                            <span class="fw-bold">آخر زيارة:</span> 15/10/2023
                        </div>
                    </div>
                </div>
            </div>

            <!-- الحالة الصحية العامة -->
            <div class="card mt-3">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">الحالة الصحية العامة</h5>
                </div>
                <div class="card-body">
                    <div class="health-info">
                        <div class="info-item mb-2">
                            <span class="fw-bold">الطول:</span> 175 سم
                        </div>
                        <div class="info-item mb-2">
                            <span class="fw-bold">الوزن:</span> 75 كجم
                        </div>
                        <div class="info-item mb-2">
                            <span class="fw-bold">ضغط الدم:</span> 120/80
                        </div>
                        <div class="info-item mb-2">
                            <span class="fw-bold">السكر:</span> 95 ملغم/ديسيلتر
                        </div>
                        <div class="info-item mb-2">
                            <span class="fw-bold">الحساسية:</span> البنسلين
                        </div>
                        <div class="info-item mb-2">
                            <span class="fw-bold">الأمراض المزمنة:</span> لا يوجد
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- قسم الكشف -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">الكشف الطبي</h5>
                </div>
                <div class="card-body">
                    <form id="examinationForm">
                        <!-- الأعراض -->
                        <div class="mb-4">
                            <label for="symptoms" class="form-label fw-bold">الأعراض</label>
                            <textarea class="form-control" id="symptoms" rows="3" placeholder="أدخل الأعراض التي يشكو منها المريض"></textarea>
                        </div>

                        <!-- التشخيص -->
                        <div class="mb-4">
                            <label for="diagnosis" class="form-label fw-bold">التشخيص</label>
                            <textarea class="form-control" id="diagnosis" rows="3" placeholder="أدخل التشخيص"></textarea>
                        </div>

                        <!-- الروشتة -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">الروشتة</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="medicineInput" placeholder="اكتب اسم الدواء">
                                <button class="btn btn-outline-primary" type="button" id="addMedicineBtn">إضافة</button>
                            </div>
                            <div id="medicineSuggestions" class="suggestions-dropdown"></div>
                            <ul class="list-group mt-2" id="medicineList">
                                <!-- سيتم إضافة الأدوية هنا -->
                            </ul>
                        </div>

                        <!-- التحاليل الطبية -->
                        <div class="mb-4">
                            <label for="medicalTests" class="form-label fw-bold">التحاليل الطبية</label>
                            <textarea class="form-control" id="medicalTests" rows="2" placeholder="أدخل التحاليل المطلوبة"></textarea>
                        </div>

                        <!-- الأشعة -->
                        <div class="mb-4">
                            <label for="radiology" class="form-label fw-bold">الأشعة</label>
                            <textarea class="form-control" id="radiology" rows="2" placeholder="أدخل الأشعة المطلوبة"></textarea>
                        </div>

                        <!-- المرفقات -->
                        <div class="mb-4">
                            <label for="attachments" class="form-label fw-bold">المرفقات (صور الأشعة، إلخ)</label>
                            <input type="file" class="form-control" id="attachments" multiple accept="image/*">
                            <div id="attachmentsPreview" class="mt-2 d-flex flex-wrap gap-2">
                                <!-- سيتم عرض معاينة المرفقات هنا -->
                            </div>
                        </div>

                        <!-- الملاحظات -->
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold">ملاحظات</label>
                            <textarea class="form-control" id="notes" rows="3" placeholder="أدخل أي ملاحظات إضافية"></textarea>
                        </div>

                        <!-- أزرار الحفظ -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary">إلغاء</button>
                            <button type="submit" class="btn btn-primary">حفظ الكشف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    
    .card-header {
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    
    .info-item {
        padding: 5px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .suggestions-dropdown {
        position: absolute;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: calc(100% - 90px);
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }
    
    .suggestion-item {
        padding: 8px 12px;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .suggestion-item:hover {
        background-color: #f8f9fa;
    }
    
    .medicine-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 12px;
    }
    
    .delete-medicine {
        color: #dc3545;
        cursor: pointer;
        background: none;
        border: none;
        font-size: 18px;
    }
    
    .attachment-preview {
        position: relative;
        width: 100px;
        height: 100px;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .attachment-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .remove-attachment {
        position: absolute;
        top: 2px;
        right: 2px;
        background: rgba(220, 53, 69, 0.8);
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const medicineInput = document.getElementById('medicineInput');
        const medicineList = document.getElementById('medicineList');
        const addMedicineBtn = document.getElementById('addMedicineBtn');
        const suggestionsDropdown = document.getElementById('medicineSuggestions');
        const attachmentsInput = document.getElementById('attachments');
        const attachmentsPreview = document.getElementById('attachmentsPreview');
        
        // قائمة الأدوية المقترحة
        const medicineSuggestions = [
            "باراسيتامول",
            "أموكسيسيلين",
            "إيبوبروفين",
            "أسبيرين",
            "ديكلوفيناك",
            "سيميتيدين",
            "أوميبرازول",
            "ميتفورمين",
            "أتينولول",
            "لوسارتان"
        ];
        
        // عرض الاقتراحات عند الكتابة
        medicineInput.addEventListener('input', function() {
            const inputValue = this.value.trim().toLowerCase();
            suggestionsDropdown.innerHTML = '';
            
            if (inputValue.length > 0) {
                const filteredSuggestions = medicineSuggestions.filter(medicine => 
                    medicine.toLowerCase().includes(inputValue)
                );
                
                if (filteredSuggestions.length > 0) {
                    filteredSuggestions.forEach(medicine => {
                        const suggestionItem = document.createElement('div');
                        suggestionItem.className = 'suggestion-item';
                        suggestionItem.textContent = medicine;
                        suggestionItem.addEventListener('click', function() {
                            medicineInput.value = medicine;
                            suggestionsDropdown.style.display = 'none';
                        });
                        suggestionsDropdown.appendChild(suggestionItem);
                    });
                    suggestionsDropdown.style.display = 'block';
                } else {
                    suggestionsDropdown.style.display = 'none';
                }
            } else {
                suggestionsDropdown.style.display = 'none';
            }
        });
        
        // إخفاء الاقتراحات عند النقر خارجها
        document.addEventListener('click', function(e) {
            if (!medicineInput.contains(e.target) && !suggestionsDropdown.contains(e.target)) {
                suggestionsDropdown.style.display = 'none';
            }
        });
        
        // إضافة دواء إلى القائمة
        function addMedicine() {
            const medicineName = medicineInput.value.trim();
            if (medicineName) {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item medicine-item';
                
                const medicineText = document.createElement('span');
                medicineText.textContent = medicineName;
                
                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'delete-medicine';
                deleteBtn.innerHTML = '&times;';
                deleteBtn.addEventListener('click', function() {
                    listItem.remove();
                });
                
                listItem.appendChild(medicineText);
                listItem.appendChild(deleteBtn);
                medicineList.appendChild(listItem);
                
                medicineInput.value = '';
                suggestionsDropdown.style.display = 'none';
            }
        }
        
        addMedicineBtn.addEventListener('click', addMedicine);
        
        medicineInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addMedicine();
            }
        });
        
        // معاينة المرفقات
        attachmentsInput.addEventListener('change', function() {
            attachmentsPreview.innerHTML = '';
            
            Array.from(this.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'attachment-preview';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        
                        const removeBtn = document.createElement('button');
                        removeBtn.className = 'remove-attachment';
                        removeBtn.innerHTML = '&times;';
                        removeBtn.addEventListener('click', function() {
                            previewDiv.remove();
                        });
                        
                        previewDiv.appendChild(img);
                        previewDiv.appendChild(removeBtn);
                        attachmentsPreview.appendChild(previewDiv);
                    };
                    
                    reader.readAsDataURL(file);
                }
            });
        });
        
        // إرسال النموذج
        document.getElementById('examinationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // هنا يمكنك إضافة كود إرسال البيانات إلى الخادم
            alert('تم حفظ بيانات الكشف بنجاح');
        });
    });
</script>
@endsection