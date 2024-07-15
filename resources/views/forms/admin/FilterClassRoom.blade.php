<table class="table" id="tableClass">
    <tbody>
        @foreach ($getdata as $data)
            <tr>
                <th scope="row">{{ $data->id }}</th>
                <td>{{ $data->cr_name }}</td>
                <td>
                    @if ($data->cr_status == 1)
                        <div class="text-primary">Active</div>
                    @else
                        <div class="text-danger">Inactive</div>
                    @endif
                </td>
                <td>
                    @if ($data->cr_deleted == 1)
                        <div class="text-success">Is Deleted</div>
                    @else
                        
                    @endif
                </td>
                <td>{{ $data->getUser->name }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-success btn-ediclass" data-bs-toggle="modal"
                        data-bs-target="#editclass" value="{{ $data->id }}">Edit</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>