<table class="table" id="table-data">
    <tbody>
        @foreach ($users as $data)
            <tr>
                <th scope="row">{{ $data->id }}</th>
                <td>{{ $data->name }}</td>
                <td>{{ $data->email }}</td>
                <td>
                    @if ($data->role == 1)
                        Admin
                    @elseif ($data->role == 2)
                        Teacher
                    @elseif ($data->role == 3)
                        Student
                    @elseif ($data->role == 4)
                        Perant
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger btn-deleteuser" data-bs-toggle="modal" data-bs-target="#userDelete" value="{{ $data->id }}" >Delete</button>
                    <button type="button" class="btn btn-sm btn-success btn-edituser" data-bs-toggle="modal" data-bs-target="#edituser" value="{{ $data->id }}">Edit</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>