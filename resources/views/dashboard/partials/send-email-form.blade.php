<div class="col">
    <div class="p-4 bg-light rounded-4">
    <h2>
        Send emails
    </h2>

    <form action="{{ route('send.email') }}" method="POST">
        @csrf
        <input type="text" placeholder="Email" class="form-control" name="email-to" value="{{ old('email-to') }}" id="email-to">
        @error('email-to')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <label for="group_id">Group</label>
        <select name="group_id[]" id="group_id" class="form-control" multiple>
            @foreach ($groups as $group)
            <option value="{{ $group->id }}">{{ $group->group_name }}</option>
            @endforeach
        </select>
    
        <input type="text" placeholder="Subject" class="form-control mt-3" name="subject" value="{{ old('subject') }}">
        @error('subject')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    
        <textarea class="form-control mt-3" rows="5" name="message" style="white-space: pre-wrap">{{ old('message') }}</textarea>
        @error('message')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <input type="checkbox" name="schedule_email" id="schedule_email">
        <label for="schedule_email">Schedule the email</label>
        <input type="datetime-local" id="schedule_datetime" name="schedule_datetime" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" style="display: none" min="{{ now()->format('Y-m-d\TH:i') }}">
        @error('schedule_datetime')
        <p class="text-danger">{{ $message }}</p>
        @enderror

    
        <input type="submit" value="Send" class="btn btn-primary mt-3 d-block">
    </form>
</div>
</div>

@push('scripts')
<script>
    document.getElementById('schedule_email').addEventListener('change', function() {
        var meetingTimeInput = document.getElementById('schedule_datetime');
        meetingTimeInput.style.display = this.checked ? 'block' : 'none';
    });
</script>
@endpush