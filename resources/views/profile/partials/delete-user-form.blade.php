<section>
    <header class="mb-4">
        <h2>
            {{ __('Delete Account') }}
        </h2>
        <p>
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button 
        type="button" 
        class="btn btn-danger" 
        data-bs-toggle="modal" 
        data-bs-target="#confirmUserDeletionModal"
    >
        {{ __('Delete Account') }}
    </button>

    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-4">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h2>

                    <p class="mt-1">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="mt-6">
                        <label for="password" class="form-label">{{ __('Password') }}</label>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control mt-1"
                            placeholder="{{ __('Password') }}"
                        />

                        @if ($errors->userDeletion->has('password'))
                            <div class="text-danger mt-2">{{ $errors->userDeletion->first('password') }}</div>
                        @endif
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>

                        <button type="submit" class="btn btn-danger ms-3">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
