@extends('layouts.app')

@section('content')

    @if (session('status'))
        <div class="mb-4 alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                
                @error('email')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />

                @error('password')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
            </div>

            <div class="d-flex justify-content-end align-items-center mt-4">
                @if (Route::has('password.request'))
                    <a class="me-3" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif

                <button class="btn btn-primary">
                    Log in
                </button>
            </div>
        </form>
@endsection