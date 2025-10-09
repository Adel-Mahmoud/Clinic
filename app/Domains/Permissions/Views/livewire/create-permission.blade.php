<div>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">

                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">اسم الصلاحية</label>
                                <input type="text" wire:model.defer="name" class="form-control" required>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">الحارس</label>
                                <input type="text" wire:model.defer="guard_name" class="form-control" required>
                                @error('guard_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary">إضافة الصلاحية</button>

                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary" wire:navigate>
                                رجوع    
                            </a>

                            <!-- <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">رجوع</a> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>