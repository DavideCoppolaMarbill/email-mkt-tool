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
                    <td>{{ $client->sex }}</td>
                    <td>{{ $client->birthday }}</td>
                    <td>
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
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>