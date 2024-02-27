@if (session('status') || $errors->any())
<script>
    const toastLiveExample = document.getElementById('liveToast');
    const toastBootstrap = new bootstrap.Toast(toastLiveExample);
    toastBootstrap.show();
</script>
@endif