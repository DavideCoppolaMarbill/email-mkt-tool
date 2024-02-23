@extends('layouts.app')

@section('content')
    <h2>
        Dashboard
    </h2>
        
    <div>
        <div>
            <div>
                <div>
                    @auth
                    <p>
                        You are logged in as <strong>{{ Auth::user()->email }}</strong>
                    </p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection