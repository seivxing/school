@extends('component.app')

@section('ShowUser', 'active')
@include('component.edit-model')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-4">
                <div class="bg-light rounded h-100 p-4">
                    @include('component.message')
                    @include('component.delete-model')
                    <form method="post" id="formAdduser" enctype="multipart/form-data">
                        @csrf
                        <p class="errMSg"></p>
                        <h6 class="mb-4">Create User</h6>
                        <div class="form-floating mb-3">
                            <input type="name" class="form-control" id="name" name="name" placeholder="Your Name">
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Your Email">
                            <label for="email">Your Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password">
                            <label for="password">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="role" name="role"
                                aria-label="Floating label select example">
                                <option value="1">Admin</option>
                                <option value="2">Teacher</option>
                                <option value="3">Student</option>
                                <option value="3">Parent</option>
                            </select>
                            <label for="floatingSelect">Works with selects</label>
                        </div>
                        <button type="button" class="btn btn-primary m-2 btn-adduser">Add</button>
                    </form>
                </div>
            </div>
            <div class="col-sm-12 col-xl-8">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Users Allllll</h6>
                    <div class="d-md-flex ms-4 gap-2 mb-2 w-95">
                        <div class="d-md-flex ms-4 gap-2 mb-2 w-100">
                            <input type="email" class="form-control form-sn broder-0" id="searchemail" placeholder="Seacher Email">
                        </div>
                        <div class="d-md-flex ms-4 gap-2 mb-2 w-75">
                            <button class="btn btn-info btn-sn btn-search">Search</button>
                        </div>
                        <div class="d-md-flex ms-4 gap-2 mb-2 w-75">
                            <select class="form-select form-select-sm" name="role" id="filter_role">
                                <option selected="">Select Role</option>
                                <option value="1">Admin</option>
                                <option value="2">Teachet</option>
                                <option value="3">Student</option>
                                <option value="3">Parent</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="table-data">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
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
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        //Ceate User
        $(document).on("click", ".btn-adduser", function(e) {
            e.preventDefault();
            var data = {
                'name': $('#name').val(),
                'email': $('#email').val(),
                'password': $('#password').val(),
                'role': $('#role').val(),
            }
            $.ajax({
                type: "post",
                url: "{{ route('admin.create') }}",
                data: data,
                datatype: "json",
                success: function(res) {
                    if (res.status == 200) {
                        $("#formAdduser")[0].reset();
                        $("#table-data").load(location.href + " #table-data");

                        Swal.fire({
                            icon: 'success',
                            title: "User Create Successfully",
                        }).then((result) => {
                            $("#table-data").load(location.href + " #table-data");
                        })

                    } else if (res.status == 400) {
                        $('.errMSg').html("");
                        $('.errMSg').addClass('text-danger');
                        $.each(res.errors, function(key, err) {
                            $('.errMSg').append('<p>' + err + '</p>')
                        });
                    }

                }
            });
        });
        //Delete User
        $(document).on("click", ".btn-deleteuser", function(e) {
            e.preventDefault();
            var userId = $(this).val();
            $('#userID').val(userId);
        });
        //Comfirm Delete User
        $(document).on("click", ".comfirmDelete", function(e) {
            e.preventDefault();
            var userIdDelete = $('#userID').val();
            $.ajax({
                type: "post",
                url: "/admin/delete/" + userIdDelete,
                data: userIdDelete,
                success: function(res) {
                    if (res.status == 200) {
                        $("#userDelete").modal("hide");
                        $("#table-data").load(location.href + " #table-data");

                        Swal.fire({
                            icon: 'success',
                            title: " User Delete Successfully",
                        }).then((result) => {
                            $("#table-data").load(location.href + " #table-data");
                        })
                    }
                }
            });
        });
        //Edit User
        $(document).on("click", ".btn-edituser", function(e) {
            e.preventDefault();
            var EditUserId = $(this).val();
            $('#editUserID').val(EditUserId);

            $.ajax({
                type: "get",
                url: "/admin/edit/" + EditUserId,
                data: EditUserId,
                success: function(res) {
                    $('#edit_name').val(res.data.name);
                    $('#edit_email').val(res.data.email);
                    $('#edit_password').val(res.data.password);
                    $('#edit_role').val(res.data.role);
                }
            })
        });
        //Update User
        $(document).on("click", ".btn-updateuser", function(e) {
            e.preventDefault();
            var UpdateUserId = $('#editUserID').val();

            var data = {
                'name': $('#edit_name').val(),
                'email': $('#edit_email').val(),
                'password': $('#edit_password').val(),
                'role': $('#edit_role').val(),
            }
            $.ajax({
                type: "put",
                url: "/admin/update/" + UpdateUserId,
                data: data,
                datatype: "json",
                success: function(res) {
                    if (res.status == 200) {
                        $("#edituser").modal("hide");
                        $("#table-data").load(location.href + " #table-data");
                    }
                }
            })
        });
        //Filter User
        $("#filter_role").on("change", function(e) {
            e.preventDefault();
            var filterUser = $(this).val();

            $.ajax({
                type: "get",
                url: "{{ route('admin.filter') }}",
                data: {
                    filterUser: filterUser,
                },
                success: function(res) {

                    $('tbody').html(res);
                    //console.log(res);

                    if (res.status == 400) {
                        Swal.fire({
                            icon: 'warning',
                            title: "Don't have with this role !!",
                        }).then((result) => {
                            $("#table-data").load(location.href + " #table-data");
                        })
                    }
                }
            });
        });
        //Button Search
        $(document).on("click", ".btn-search", function(e) {
            e.preventDefault();
            var search = $('#searchemail').val();

            $.ajax({
                type: "get",
                url: "{{ route('admin.search') }}",
                data: {
                    search: search,
                },
                success: function(res) {
                    $('tbody').html(res);
                    if (res.status == 400) {

                    }
                }
            });
        });
    });
</script>
@endsection
