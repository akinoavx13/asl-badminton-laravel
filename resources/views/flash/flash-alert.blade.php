@if(session()->has('flash_alert'))
    <script>
        swal({
            title: "{{ session('flash_alert.title') }}",
            text: "{{ session('flash_alert.message') }}",
            type: "{{ session('flash_alert.level') }}",
            timer: 2000,
            showConfirmButton: false,
        });
    </script>
@endif

@if(session()->has('flash_alert_overlay'))
    <script>
        swal({
            title: "{{ session('flash_alert_overlay.title') }}",
            text: "{{ session('flash_alert_overlay.message') }}",
            type: "{{ session('flash_alert_overlay.level') }}",
            confirmButtonText: 'Okay',
        });
    </script>
@endif