@props(['sectionPage' => null, 'titlePage' => 'Title Page'])

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            @if($sectionPage)
                <h4 class="content-title mb-0 my-auto">{{ $sectionPage }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ $titlePage }}</span>
            @else
                <h4 class="content-title mb-0 my-auto">{{ $titlePage }}</h4>
            @endif
        </div>
    </div>
</div>
@endsection
