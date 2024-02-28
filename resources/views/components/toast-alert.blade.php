<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto"><i class="bi bi-bell-fill me-2"></i>Update</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        @if (session('status'))
            {{ session('status') }}
        @endif
        @if ($errors->any())
            <div class="alert alert-danger mb-0">
                <ul class="list-unstyled mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
  </div>
</div>

@push('scripts')
  @if (session('status') || $errors->any())
  <script>
      const toastLiveExample = document.getElementById('liveToast');
      const toastBootstrap = new bootstrap.Toast(toastLiveExample);
      toastBootstrap.show();
  </script>
  @endif
@endpush