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

        <section>
            @include('dashboard.partials.add-clients-form')
        </section>

        <section>
            @include('dashboard.partials.send-email-form')
        </section>

    </div>
@endsection