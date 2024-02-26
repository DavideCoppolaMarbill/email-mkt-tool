<h1>
    Client list
</h1>

<div class="table-responsive">
    <table class="table">
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
                        @foreach($client->clientGroups as $group)
                        <span class="bg-primary text-white rounded-pill px-2 py-1">
                            {{ $group->group_name }}
                        </span>
                        @endforeach
                    </td>
                    <td>{{ $client->sex }}</td>
                    <td>{{ $client->birthday }}</td>
                    <td class="d-flex gap-2">
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
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

<script>
        function addEmail(email) {
            let emailList = document.getElementById('email-to')
            emailList.value = emailList.value + ' ' + email
        }
</script>