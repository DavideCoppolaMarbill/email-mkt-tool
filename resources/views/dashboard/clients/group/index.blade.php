@extends('layouts.app')

@section('content')
    <h1>
        Add groups for your clients
    </h1>

    <div>
        @foreach ($groups as $group)
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">{{ $group->group_name }}</h5>
                <div class="d-flex gap-2">
                    <form action="{{ route('groups.destroy', $group->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i  class="bi bi-trash"></i>
                        </button>
                    </form>
                    <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <form action="{{ route('groups.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Group name">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>

@endsection