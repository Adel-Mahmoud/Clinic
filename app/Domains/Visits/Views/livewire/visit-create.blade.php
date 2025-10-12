<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">إضافة زيارة جديدة</h4>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">المريض <span class="text-danger">*</span></label>
                        @if($patient_id)
                        <div class="form-control bg-light">
                            {{ $search }}
                        </div>
                        @else
                        <div class="position-relative">
                            <div class="input-group">
                                <input
                                    type="text"
                                    wire:model.live.300ms="search"
                                    class="form-control @error('patient_id') is-invalid @enderror"
                                    placeholder="ابحث باسم المريض، الهاتف أو البريد الإلكتروني..."
                                    autocomplete="off">
                                @if($patient_id)
                                <button
                                    type="button"
                                    wire:click="clearPatient"
                                    class="btn btn-outline-danger"
                                    title="مسح الاختيار">
                                    <i class="fas fa-times"></i>
                                </button>
                                @endif
                                <a href="{{ route('admin.patients.create') }}" class="btn btn-outline-primary" title="إضافة مريض جديد">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>

                            @if($showDropdown && count($patients) > 0)
                            <div class="dropdown-menu show w-100" style="display: block; position: absolute; z-index: 1000;">
                                @foreach($patients as $patient)
                                <button
                                    type="button"
                                    wire:click="selectPatient({{ $patient->id }})"
                                    class="dropdown-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $patient->user->name }}</strong>
                                            @if($patient->phone)
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-phone"></i> {{ $patient->phone }}
                                            </small>
                                            @endif
                                        </div>
                                        <small class="text-muted">#{{ $patient->id }}</small>
                                    </div>
                                </button>
                                @endforeach
                            </div>
                            @elseif($showDropdown && strlen($search) >= 2)
                            <div class="dropdown-menu show w-100" style="display: block; position: absolute; z-index: 1000;">
                                <div class="dropdown-item text-muted text-center">
                                    <i class="fas fa-search me-2"></i>
                                    لا توجد نتائج لـ "{{ $search }}"
                                </div>
                            </div>
                            @endif

                            @if($patient_id && $search)
                            <div class="mt-2 p-2 bg-light rounded">
                                <small class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    تم اختيار: <strong>{{ $search }}</strong>
                                </small>
                            </div>
                            @endif
                        </div>
                        @error('patient_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <small class="form-text text-muted">
                            ابدأ بالكتابة للبحث (حد أدنى حرفين)
                        </small>
                        @endif
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
                        إضافة زيارة جديدة
                    </button>
                    @if($patient_id)
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">إلغاء</a>
                    @else
                    <a href="{{ route('admin.visits.index') }}" class="btn btn-secondary">إلغاء</a>
                    @endif
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
            priceInput.innerText = price ? parseFloat(price).toFixed(2) : '0.00';
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.position-relative')) {
                Livewire.dispatch('close-dropdown');
            }
        });
    });
</script>
@endpush