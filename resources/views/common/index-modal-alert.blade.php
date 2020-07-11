<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

<div class="modal fade" id="delete-modal">
    <div class="modal-dialog delete-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Confirmation') }}</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('Are you sure to delete?') }}</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <form id="form-delete" action="" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(function() {
        $('#delete-modal').on('show.bs.modal', function (e) {
            var href = $(e.relatedTarget).attr('href');

            $('#form-delete', this).attr('action', href);
        });

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