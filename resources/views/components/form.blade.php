@props([
'action',
'method' => 'POST',
'submitLabel' => 'حفظ',
'cancelRoute' => null,
])
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (strtoupper($method) !== 'POST')
                    @method($method)
                    @endif

                        {{ $slot }}

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>

                        @if($cancelRoute)
                        <a href="{{ route($cancelRoute) }}" class="btn btn-secondary">رجوع</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>