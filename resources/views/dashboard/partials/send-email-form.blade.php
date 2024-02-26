<div>
    <h2>
        Send emails
    </h2>

    <form action="{{ route('send.email') }}" method="POST">
        @csrf
        <input type="text" placeholder="Email" class="form-control" name="email-to" value="{{ old('email-to') }}" id="email-to">
        @error('email-to')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    
        <input type="text" placeholder="Subject" class="form-control mt-3" name="subject" value="{{ old('subject') }}">
        @error('subject')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    
        <textarea class="form-control mt-3" rows="5" name="message">{{ old('message') }}</textarea>
        @error('message')
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <input type="checkbox" name="schedule_email" id="schedule_email">
        <label for="schedule_email">Schedule the email</label>
        <input type="datetime-local" id="schedule_datetime" name="schedule_datetime" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" style="display: none" min="{{ now()->format('Y-m-d\TH:i') }}">

    
        <input type="submit" value="Send" class="btn btn-primary mt-3 d-block">
    </form>
    
</div>

<script>
    document.getElementById('schedule_email').addEventListener('change', function() {
        var meetingTimeInput = document.getElementById('schedule_datetime');
        meetingTimeInput.style.display = this.checked ? 'block' : 'none';
    });
</script>