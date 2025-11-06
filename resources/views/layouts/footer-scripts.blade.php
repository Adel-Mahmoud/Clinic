<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- JQuery min js -->
<script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap Bundle js -->
<script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/plugins/ionicons/ionicons.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>

<!-- Rating js-->
<script src="{{URL::asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
<script src="{{URL::asset('assets/plugins/rating/jquery.barrating.js')}}"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="{{URL::asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<!-- <script src="{{URL::asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script> -->
<!--Internal Sparkline js -->
<script src="{{URL::asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<!-- Custom Scroll bar Js-->
<script src="{{URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- right-sidebar js -->
<script src="{{URL::asset('assets/plugins/sidebar/sidebar-rtl.js')}}"></script>
<script src="{{URL::asset('assets/plugins/sidebar/sidebar-custom.js')}}"></script>
<!-- Eva-icons js -->
<script src="{{URL::asset('assets/js/eva-icons.min.js')}}"></script>
@yield('js')
@stack('js')
<!-- Sticky js -->
<script src="{{URL::asset('assets/js/sticky.js')}}"></script>
<!-- custom js -->
<script src="{{URL::asset('assets/js/custom.js')}}"></script><!-- Left-menu js-->
<script src="{{URL::asset('assets/plugins/side-menu/sidemenu.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/sweet-alert/jquery.sweet-alert.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.addEventListener('swal:confirm', event => {
            const detail = Array.isArray(event.detail) ? event.detail[0] : event.detail;

            swal({
                title: detail.title || "هل أنت متأكد؟",
                text: detail.text || "سيتم الحذف ولا يمكن التراجع!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "نعم، احذف",
                cancelButtonText: "إلغاء",
            }, (isConfirm) => {
                if (!isConfirm) return;

                if (detail.type === 'bulk') {
                    Livewire.dispatch('deleteSelected');
                } else if (detail.id) {
                    Livewire.dispatch('deleteItem', {
                        id: detail.id
                    });
                }
            });
        });

        window.addEventListener('swal:success', event => {
            const detail = Array.isArray(event.detail) ? event.detail[0] : event.detail;

            swal({
                title: detail.title || "تمت العملية بنجاح",
                text: detail.text || "",
                type: "success",
                button: "موافق"
            }, () => {
                if (detail.redirect) {
                    window.location.href = detail.redirect;
                }
            });
        });

        window.addEventListener('swal:error', event => {
            const detail = Array.isArray(event.detail) ? event.detail[0] : event.detail;

            swal({
                title: detail.title || "حدث خطأ",
                text: detail.text || "يرجى المحاولة لاحقاً.",
                type: "error",
                button: "موافق"
            });
        });

        @if(session('swal'))
        swal({
            title: "{{ session('swal')['title'] ?? 'تم بنجاح' }}",
            text: "{{ session('swal')['text'] ?? '' }}",
            type: "{{ session('swal')['type'] ?? 'success' }}",
            button: "موافق"
        }, () => {
            @if(session('swal')['redirect'] ?? false)
            window.location.href = "{{ session('swal')['redirect'] }}";
            @endif
        });
        @endif
    });
</script>