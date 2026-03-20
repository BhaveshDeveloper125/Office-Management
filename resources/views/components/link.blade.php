{{-- ── Google Fonts ── --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

{{-- ── Toastr CSS ── --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

{{-- ── Font Awesome 6 Free ── --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

{{-- ── Shared App CSS ── --}}
<link rel="stylesheet" href="{{ asset('css/common.css') }}">

{{-- ── jQuery ── --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

{{-- ── Toastr JS ── --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // Toastr default settings
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-bottom-right',
        timeOut: 900
    };
</script>

@if (session('success'))
    <script>toastr.success("{{ session('success') }}");</script>
@endif

@if (session('error'))
    <script>toastr.error("{{ session('error') }}");</script>
@endif
