<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
<!-- pace-progress -->
<script src="{{ asset('assets/plugins/pace-progress/pace.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

<!-- Custom styles for SweetAlert2 -->
<style>
    .swal2-container {
        z-index: 9999 !important;
    }

    .swal2-popup {
        font-size: 1rem !important;
    }

    body.swal2-shown> :not(.swal2-container) {
        filter: blur(2px);
    }
</style>

<!-- Load SweetAlert2 first, then initialize notification handlers -->
<script>
    // Ensure SweetAlert2 is available globally
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swal !== 'undefined') {
            window.Swal = Swal.mixin({
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                reverseButtons: true
            });
        }
    });
</script>

<!-- Custom notification handlers -->
<script src="{{ asset('assets/js/notifications.js') }}"></script>

<!-- Logout confirmation -->
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out of the system!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, logout!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>

<!-- Password change validation -->
<script>
    $(document).ready(function() {
        // Validate the change password form
        $('#changePasswordModal form').submit(function(e) {
            const password = $('#new_password').val();
            const confirmation = $('#password_confirmation').val();

            if (password !== confirmation) {
                e.preventDefault();
                toastr.error('New password and confirmation do not match');
                return false;
            }

            if (password.length < 8) {
                e.preventDefault();
                toastr.error('Password must be at least 8 characters long');
                return false;
            }

            return true;
        });

        // Reset form when modal is closed
        $('#changePasswordModal').on('hidden.bs.modal', function() {
            $('#changePasswordModal form')[0].reset();
        });
    });
</script>

@stack('scripts')

<script>
    // Check for flash messages
    document.addEventListener('DOMContentLoaded', function() {
        // Handle error messages
        @if (session('error'))
            toastr.error('{{ session('error') }}');
        @endif

        // Handle success messages
        @if (session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        // Handle info messages
        @if (session('info'))
            toastr.info('{{ session('info') }}');
        @endif

        // Handle warning messages
        @if (session('warning'))
            toastr.warning('{{ session('warning') }}');
        @endif

        // Handle toast_error from exception handler
        @if (session('toast_error'))
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: '{{ session('alert_type') ?? 'error' }}',
                    title: '{{ session('alert_title') ?? 'Error' }}',
                    text: '{{ session('toast_error') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            } else {
                alert('{{ session('toast_error') }}');
            }
        @endif

        // Handle toast_success
        @if (session('toast_success'))
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('toast_success') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            } else {
                alert('{{ session('toast_success') }}');
            }
        @endif
    });
</script>

<!-- Navigation Menu JS -->
<script>
    $(document).ready(function() {
        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });
    });
</script>
