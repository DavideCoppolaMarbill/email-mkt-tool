@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            {{ __('Profile') }}
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            @include('profile.partials.update-profile-information-form')
                        </div>

                        <div class="mb-4">
                            @include('profile.partials.update-password-form')
                        </div>

                        <div>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
