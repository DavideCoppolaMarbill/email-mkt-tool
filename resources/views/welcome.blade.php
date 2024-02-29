@extends('layouts.app')

@section('content')
    <div class="row gy-4">
        <div class="col d-flex align-items-center">
            <div>
                <h1 class="display-1 fw-bold">Welcome</h1>
                <p>
                    This is a email marketing tool.
                </p>
                <a href="{{ route('register') }}" class="btn btn-primary mt-3">
                    @if(Auth::check())
                    Dashboard
                    @else
                    Register
                    @endif
                </a>
            </div>
        </div>
        <div class="col">
            <img src="{{ asset('img/hero.jpg') }}" alt="Example Image" class="w-100">
        </div>
    </div>
@endsection