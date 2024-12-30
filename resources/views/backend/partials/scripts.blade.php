
<!-- latest jquery-->
<script src="{{asset('backend/js/jquery-3.6.0.min.js')}}"></script>

<!-- Bootstrap js-->
<script src="{{asset('backend/js/bootstrap/bootstrap.bundle.min.js')}}"></script>

<!-- feather icon js-->
<script src="{{asset('backend/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{asset('backend/js/icons/feather-icon/feather-icon.js')}}"></script>


<!-- scrollbar js-->
<script src="{{asset('backend/js/scrollbar/simplebar.js')}}"></script>
<script src="{{asset('backend/js/scrollbar/custom.js')}}"></script>


<!-- Sidebar jquery-->

<script src="{{asset('backend/js/config.js')}}"></script>
<script src="{{asset('backend/js/sidebar-menu.js')}}"></script>

<script src="{{asset('backend/js/notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('backend/js/icons/icons-notify.js')}}"></script>


<script src="{{asset('backend/js/dashboard/default.js')}}"></script>
{{-- //for notification --}}
<script>
    var notifyMessage = @json(session('notify-success'));
    var notifyMessageWarning = @json(session('notify-warning'));
</script>
<script src="{{asset('backend/js/notify/index.js')}}"></script>

{{--datatable--}}
<script src="{{asset('backend/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/js/datatable/datatables/datatable.custom.js')}}"></script>
<script src="{{asset('backend/js/tooltip-init.js')}}"></script>



{{-- dropify start --}}

<script src="{{ asset('backend/js/dropify.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
{{-- dropify end --}}


{{-- sweetalert --}}
<script src="{{ asset('backend/cdn/js/sweetalert2@11.js') }}"></script>


<script src="{{ asset('backend/js/ckeditor.js') }}"></script>


<!-- Template js-->
<script src="{{asset('backend/js/script.js')}}"></script>

@stack('scripts')

<!-- login js-->
