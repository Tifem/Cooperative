<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if ($errors->any())
        Swal.fire('Oops...', "{!! implode('', $errors->all('<p>:message</p>')) !!}", 'error')
    @endif

    @if (session()->has('message'))
        Swal.fire(
        'Success!',
        "{{ session()->get('message') }}",
        'success'
        )
    @endif
    @if (session()->has('success'))
        Swal.fire(
        'Success!',
        "{{ session()->get('success') }}",
        'success'
        )
    @endif
</script>
