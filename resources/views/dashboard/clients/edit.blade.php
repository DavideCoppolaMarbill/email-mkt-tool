@extends('layouts.app')

@section('content')
<form action="{{ route('client.update', $client->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="form-group">
        <label for="first_name">Name</label>
        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $client->first_name }}">

        @error('name')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $client->last_name }}">

        @error('last_name')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="email">Email</label>
        <input type="text" name="email" id="email" class="form-control" value="{{ $client->email }}">

        <label for="group_id">Group</label>
        <select name="group_id[]" id="group_id" class="form-control" multiple>
            @foreach ($groups as $group)
            <option value="{{ $group->id }}" {{ $client->clientGroups->contains($group)?'selected' : '' }}>
                {{ $group->group_name }}
            </option>
            @endforeach
        </select>

        @error('email')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="sex">Sex</label>
        <select name="sex" id="sex" class="form-control">
            <option value="male" {{ $client->sex =='male'?'selected' : '' }}>Male</option>
            <option value="female" {{ $client->sex == 'female'?'selected' : '' }}>Female</option>
            <option value="other" {{ $client->sex == 'other'?'selected' : '' }}>Other</option>
        </select>

        @error('sex')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label for="birthday">Birthday</label>
        <input type="date" name="birthday" id="birthday" class="form-control" value="{{ $client->birthday }}">

        @error('birthday')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <input type="submit" value="Update" class="btn btn-primary mt-3">
</form>
@endsection