@props(['section' => null])

@push('css')
<link href="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
@endpush

{{ $slot }}

@push('js')
<script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/sweet-alert/jquery.sweet-alert.js') }}"></script>

<script>
    window.addEventListener('swal:confirm', event => {
        const detail = Array.isArray(event.detail) ? event.detail[0] : event.detail;

        swal({
            title: detail.title || "هل أنت متأكد؟",
            text: detail.text || "سيتم الحذف ولا يمكن التراجع!",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "نعم، احذف",
            cancelButtonText: "إلغاء",
        }, function(isConfirm) {
            if (!isConfirm) return;

            if (detail.type === 'bulk') {
                Livewire.dispatch('deleteSelected');
            } else {
                Livewire.dispatch('delete{{ $section }}', [detail.id]);
            }
        });
    });

    window.addEventListener('swal:success', event => {
        const detail = Array.isArray(event.detail) ? event.detail[0] : event.detail;

        swal(
            detail.title || "تمت العملية بنجاح",
            detail.text || "",
            "success"
        );
    });
</script>

@if(session('swal'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        swal({
            title: "{{ session('swal')['title'] }}",
            text: "{{ session('swal')['text'] }}",
            type: "{{ session('swal')['type'] }}",
            button: "موافق"
        });
    });
</script>
@endif
@endpush