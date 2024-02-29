@extends('layouts.app')

@section('content')


<h1>
    Edit group
</h1>

<form action="{{ route('groups.update', $group->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <input type="text" name="group_name" class="form-control" value="{{ $group->group_name }}">
    <input type="submit" class="btn btn-primary mt-3" value="Update">
</form>
@endsection