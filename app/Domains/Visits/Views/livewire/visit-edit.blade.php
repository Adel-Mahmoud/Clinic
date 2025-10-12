<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">تعديل الزيارة</h4>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="update">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">المريض <span class="text-danger">*</span></label>
                        <input type="hidden" wire:model="patient_id" value="{{ $patient_id }}">
                        <div class="form-control">{{ $patient_name }}</div>
                        @error('patient_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">الخدمة <span class="text-danger">*</span></label>
                        <select id="service_id" wire:model="service_id" class="form-control @error('service_id') is-invalid @enderror">
                            <option value="">اختر الخدمة</option>
                            @foreach($services as $service)
                            <option data-price="{{ $service->price }}" value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                        @error('service_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">تاريخ الزيارة <span class="text-danger">*</span></label>
                        <input type="date" wire:model="visit_date" class="form-control @error('visit_date') is-invalid @enderror">
                        @error('visit_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">وقت الزيارة <span class="text-danger">*</span></label>
                        <input type="time" wire:model="visit_time" class="form-control @error('visit_time') is-invalid @enderror">
                        @error('visit_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">السعر</label>
                        <div id="price" class="form-control">0.00</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">حالة الزيارة <span class="text-danger">*</span></label>
                        <select wire:model="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="pending">معلق</option>
                            <option value="completed">مكتمل</option>
                            <option value="canceled">ملغي</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">ملاحظات</label>
                        <textarea wire:model="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="ملاحظات إضافية..."></textarea>
                        @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary">
                        تحديث الزيارة
                    </button>
                    <a href="{{ route('admin.visits.index') }}" class="btn btn-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const serviceSelect = document.getElementById('service_id');
        const priceInput = document.getElementById('price');

        serviceSelect.addEventListener('change', function() {
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            priceInput.innerText = price || '';
        });

        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        if (selectedOption) {
            const price = selectedOption.getAttribute('data-price');
            if (price) {
                priceInput.innerText = price;
            }
        }
    });
</script>
@endpush