<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">إضافة زيارة جديدة</h4>
            <h1>
                @if(isset($patientId))
                  {{patientId}}
                @endif
            </h1>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">المريض <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select wire:model="patient_id" class="form-control @error('patient_id') is-invalid @enderror">
                                <option value="">اختر المريض</option>
                                @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                                @endforeach
                            </select>
                            <a href="{{ route('admin.patients.create') }}" class="btn btn-outline-primary mr-1" title="إضافة مريض جديد">
                                <i class="fas fa-plus"></i>
                            </a>
                            @error('patient_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">الخدمة <span class="text-danger">*</span></label>
                        <select wire:model="service_id" class="form-control @error('service_id') is-invalid @enderror">
                            <option value="">اختر الخدمة</option>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
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
                        <label class="form-label fw-bold">السعر <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" wire:model="price" class="form-control @error('price') is-invalid @enderror" placeholder="0.00">
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                        إضافة زيارة جديدة
                    </button>
                    <a href="{{ route('admin.visits.index') }}" class="btn btn-secondary">إلغاء</a>
                </div>

            </form>
        </div>
    </div>
</div>