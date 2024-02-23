@extends('layouts.app')

@section('content')
    <div>
        <h1>Welcome</h1>
        <p>
            This is a email marketing tool.
        </p>
        <a href="{{ route('register') }}" class="btn btn-primary">
            @if(Auth::check())
                Dashboard
                @else
                Register
            @endif
        </a>
    </div>
@endsection