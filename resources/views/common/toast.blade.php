<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(function() {
        @if(Session::has('message'))
            const toastMessage = "@php echo Session::get('message'); @endphp";
            const toastStatus = "@php echo Session::get('alert-class') @endphp";

            const Toast = Swal.mixin({
                toast: true,
                position: 'center',
                showConfirmButton: true,
                timer: 5000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: toastStatus,
                title: toastMessage
            })
        @endif
    });
</script>