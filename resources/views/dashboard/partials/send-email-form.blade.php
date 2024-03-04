<div class="col">
    <div class="p-4 bg-light rounded-4">
        <h2>
            Send emails
        </h2>

        <form action="{{ route('send.email') }}" method="POST" name="your_form_name" id="sendEmailForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="form_name" value="send_email_form">

            <label for="email-to">Emails</label>
            <br>
            <small>You can insert multiple and separate them with a space</small>
            <input type="text" placeholder="Emails" class="form-control" name="email-to" value="{{ old('email-to') }}" id="email-to">
            @error('email-to')
            <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="group_id">Group</label>
            <select name="group_id[]" id="group_id" class="form-control" multiple>
                @foreach ($groups as $group)
                <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                @endforeach
            </select>
            @error('group_id')
                @if(old('form_name') == 'send_email_form')
                    <p class="text-danger">{{ $message }}</p>
                @endif
            @enderror

            <div>
                <p class="my-2">
                    Customize email with dynamic variables:
                </p>
                <div class="d-flex flex-wrap gap-2 text-white" style="font-size: 0.8rem">
                    <p class="bg-primary rounded-pill px-2 py-1">{first_name}</p>
                    <p class="bg-primary rounded-pill px-2 py-1">{last_name}</p>
                    <p class="bg-primary rounded-pill px-2 py-1">{birthday}</p>
                    <p class="bg-primary rounded-pill px-2 py-1">{sex}</p>
                </div>
            </div>
            

            <input type="text" placeholder="Subject" class="form-control mt-3" name="subject" value="{{ old('subject') }}" required>
            @error('subject')
            <p class="text-danger">{{ $message }}</p>
            @enderror

            <textarea class="form-control mt-3" rows="5" placeholder="Your message" name="message" style="white-space: pre-wrap" required>{{ old('message') }}</textarea>
            @error('message')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <input type="file" name="attachment" id="attachment" class="form-control mt-3" accept="image/png, image/jpeg, image/jpg">
            @error('attachment')
            <p class="text-danger">{{ $message }}</p>
            @enderror

            <input type="checkbox" name="schedule_email" id="schedule_email" class="mt-3">
            <label for="schedule_email">Schedule the email</label>
            <input type="datetime-local" id="schedule_datetime" name="schedule_datetime" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" style="display: none" min="{{ now()->format('Y-m-d\TH:i') }}">
            @error('schedule_datetime')
            <p class="text-danger">{{ $message }}</p>
            @enderror

            <input type="submit" value="Send" class="btn btn-primary mt-3 d-block" id="submitButton">
        </form>
    </div>
</div>

@push('scripts')

<script>
    document.getElementById('submitButton').addEventListener('click', function(event) {
        var fileInput = document.getElementById('attachment');
        var fileSize = fileInput.files[0].size; // in bytes
        fileSize = fileSize / 1024 / 1024; // in MB
        var maxSize = 1;

        if (fileSize > maxSize) {
            fileInput.setCustomValidity('File size must be a jpeg or png less than 1MB');
            fileInput.reportValidity();
            event.preventDefault(); // prevent form submission
        } else {
            fileInput.setCustomValidity('');
        }
    });
</script>

<script>
    var form = document.getElementById('sendEmailForm');
    var emailToInput = form.querySelector('#email-to');
    var groupIdSelect = form.querySelector('#group_id');

    document.getElementById('submitButton').addEventListener('click', function() {
        var emailTo = emailToInput.value.trim();
        var groupIds = groupIdSelect.selectedOptions;

        if (emailTo === '' && groupIds.length === 0) {
            emailToInput.setCustomValidity('Either "Emails" or "Group" must be filled');
            groupIdSelect.setCustomValidity('Either "Emails" or "Group" must be filled');
            emailToInput.reportValidity();
            groupIdSelect.reportValidity();
        } else {
            emailToInput.setCustomValidity('');
            groupIdSelect.setCustomValidity('');
        }
    });

    document.getElementById('schedule_email').addEventListener('change', function() {
        var meetingTimeInput = document.getElementById('schedule_datetime');
        meetingTimeInput.style.display = this.checked ? 'block' : 'none';
    });
</script>
@endpush
