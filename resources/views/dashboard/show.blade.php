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
            @include('dashboard.partials.add-clients-form')
        </section>
    </div>
@endsection