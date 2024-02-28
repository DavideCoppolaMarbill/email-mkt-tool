
<div class="col ">
<div class="bg-light p-4 rounded-4">
    <h2>
        Add a new client
    </h2>
    
    <form action="{{ route('client.store') }}"method="POST">
        @csrf
        <input type="hidden" name="form_name" value="add_client_form">
        <div class="form-group">
            <label for="first_name">Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}">
            
            @error('first_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}">
            
            @error('last_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
            
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            
            <label for="sex">Sex</label>
            <select name="sex" id="sex" class="form-control">
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            @error('sex')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            
            <label for="group_id">Group</label>
            <select name="group_id[]" id="group_id" class="form-control" multiple>
                @foreach ($groups as $group)
                <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                @endforeach
x            </select>
            @error('group_id')
                @if(old('form_name') == 'add_client_form')
                    <p class="text-danger">{{ $message }}</p>
                @endif
            @enderror
            
            <label for="birthday">Birthday</label>
            <input type="date" name="birthday" id="birthday" class="form-control" value="{{ old('birthday') }}">
            
            @error('birthday')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            
            <input type="submit" value="Add" class="btn btn-primary mt-3">
        </form>
    </div>
</div>
</div>