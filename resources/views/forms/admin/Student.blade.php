@extends('component.app')

@section('sudent', 'active')

@section('content')
    <div class="bg-light rounded h-100 p-4">
        @include('component.add-student-offcanvas')
        @include('component.edit-student-model')
        <div class="mb-2"><button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Students</button></div>
        <div class="table-responsive">
            <table class="table align-middle mt-2 mb-0" id="tablestudents">
                <thead>
                    <tr>
                        <th scope="col">Photo</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Status</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($studentData as $data)
                        <tr>
                            <th> <img src="{{ asset('storage/images/' . $data->profile) }}" class="rounded"
                                    style="width:auto ; height:100px;"></th>
                            <td>{{ $data->fname }} {{ $data->lname }}</td>
                            <td>
                                @if ($data->gender == 1)
                                    <div>Male</div>
                                @elseif ($data->gender == 2)
                                    <div>Female</div>
                                @else
                                    <div>Other</div>
                                @endif
                            </td>
                            <td>
                                {{ $data->dob }}
                            </td>
                            <td>
                                @if ($data->sub_status == 1)
                                    <div class="text-primary">Active</div>
                                @else
                                    <div class="text-danger">Inactive</div>
                                @endif
                            </td>
                            <td> {{ $data->phone }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success btn-editstudent" data-bs-toggle="modal"
                                    data-bs-target="#editstudent" value="{{ $data->id }}">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
            // Create Student
            $(document).on("click", '.btn-addstudent', function(e) {
                e.preventDefault();

                let formData = new FormData($('#formaddstudent')[0])
                $.ajax({
                    type: "post",
                    url: "{{ route('admin.addstudent') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        $("#offcanvasRight").offcanvas('hide');
                        $("#formaddstudent")[0].reset();
                        $("#tablestudents").load(location.href + " #tablestudents");

                        Swal.fire({
                            icon: 'success',
                            title: "User Create Successfully",
                        }).then((result) => {
                            $("#tablestudents").load(location.href + " #tablestudents");
                        })
                    }
                });
            });

            //Edit Student
            $(document).on("click", '.btn-editstudent', function(e) {
                e.preventDefault();

                var sudentid = $(this).val();
                $("#editstudentID").val(sudentid);

                $.ajax({
                    type: "get",
                    url: "/admin/editstudent/" + sudentid,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#updatefname').val(res.data.fname);
                            $('#updatelname').val(res.data.lname);
                            $('#updatedob').val(res.data.dob);
                            $('#updatephone').val(res.data.phone);
                            $('#updategender').val(res.data.gender);
                        }
                    }
                });
            });

            //Update Student Information1
            $(document).on("click", '.btn-updatestudent', function(e) {
                e.preventDefault();

                let editstudentID = $("#editstudentID").val();
                let formeditstudent = new FormData($('#formeditstudent')[0])

                $.ajax({
                    type: "post",
                    url: "/admin/updatestudent/" + editstudentID,
                    data: formeditstudent,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $("#editstudent").modal('hide');
                            $("#tablestudents").load(location.href + " #tablestudents");

                            Swal.fire({
                                icon: 'success',
                                title: "Student Update successfully",
                            }).then((result) => {
                                $("#tablestudents").load(location.href +
                                    " #tablestudents");
                            })
                        }
                    }
                });
            });

        });
    </script>
@endsection
