@extends('layouts.app')

@section('content')
    <h2>
        Dashboard
    </h2>
    
    <div>
        @auth
            <p>
                You are logged in as <strong>{{ Auth::user()->email }}</strong>
            </p>
        @endauth

        <section>
            @include('dashboard.partials.clients-list')
        </section>

        <section class="row row-cols-2 gy-4">
            @include('dashboard.partials.add-clients-form')
            @include('dashboard.partials.send-email-form')
        </section>

    </div>
@endsection