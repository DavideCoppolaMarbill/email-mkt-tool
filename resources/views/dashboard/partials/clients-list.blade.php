<h1 class="text-center">
    Client list
</h1>

<div class="table-responsive" id="client-table">
    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Groups</th>
                <th>Sex</th>
                <th>Birthday</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
            <tr>
                    <td>{{ $client->first_name }}</td>
                    <td>{{ $client->last_name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>
                        <div class="overflow-x-auto d-flex gap-2" style="max-width: 250px;">
                            @foreach($client->clientGroups as $group)
                            <div class="bg-primary text-white rounded-pill px-2 py-1" style="min-width: fit-content">
                                {{ $group->group_name }}
                            </div>
                            @endforeach
                        </div>
                    </td>
                    <td>{{ $client->sex }}</td>
                    <td>{{ $client->birthday }}</td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('client.edit', $client->id) }}" class="btn btn-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('client.destroy', $client->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            <button class="btn btn-success" onclick="addEmail('{{ $client->email }}')">
                                <i class="bi bi-plus-circle"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $clients->links() }}
</div>

@push('scripts')
<script>
        function addEmail(email) {
            let emailList = document.getElementById('email-to')
            emailList.value = emailList.value + ' ' + email
        }
</script>
@endpush