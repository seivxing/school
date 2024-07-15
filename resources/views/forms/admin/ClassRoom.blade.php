@extends('component.app')

@section('classroom', 'active')
@include('component.editclass-model')
@include('component.assign-subject-model')
@section('content')
    <div class="bg-light rounded h-100 p-4">
        @include('component.add-new-class-model')
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addnewclass">New Class</button>
        <div class="mb-2 w-25">
            <select class="form-select form-select-sm" name="cr_status" id="filter_status">
                <option>Select Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <div class="table-responsive">
            <table class="table" id="tableClass">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Class Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Deleted</th>
                        <th scope="col">Create</th>
                        <th scope="col">Action</th>
                        <th scope="col">Assign</th>
                    </tr>
                </thead>
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
                            <td>
                                <button type="button" class="btn btn-sm btn-primary btn-assignsubject" data-bs-toggle="modal"
                                    data-bs-target="#assignsubject"  value="{{ $data->id }}">AssignSubject</button>
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
            //Ceate User
            $(document).on("click", ".btn-addclass", function(e) {
                e.preventDefault();

                var data = {
                    'cr_name': $('#cr_name').val(),
                    'cr_create_by': $('#cr_create_by').val(),
                }

                $.ajax({
                    type: "post",
                    url: "{{ route('admin.addclass') }}",
                    data: data,
                    datatype: "json",
                    success: function(res) {
                        if (res.status == 200) {
                            $("#addnewclass").modal('hide');
                            $("#formaddsubject")[0].reset();
                            $("#tableClass").load(location.href + " #tableClass");

                            Swal.fire({
                                icon: 'success',
                                title: "Class Create Successfully",
                            }).then((result) => {
                                $("#table-data").load(location.href + " #table-data");
                            })

                        }
                        // else if (res.status == 400) {
                        //     $('.errMSg').html("");
                        //     $('.errMSg').addClass('text-danger');
                        //     $.each(res.errors, function(key, err) {
                        //         $('.errMSg').append('<p>' + err + '</p>')
                        //     });
                        // }

                    }
                });
            });
            //Edit User
            $(document).on("click", ".btn-ediclass", function(e) {
                e.preventDefault();
                var classid = $(this).val();
                $('#editclassid').val(classid);

                $.ajax({
                    type: "get",
                    url: "/admin/editclass/" + classid,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#edit_cr_name').val(res.data.cr_name);
                            if (res.data.cr_status == 1) {
                                $('#edit_cr_status').val(res.data.cr_status).prop('checked',
                                    true);
                            }
                            if (res.data.cr_deleted == 1) {
                                $('#edit_cr_deleted').val(res.data.cr_deleted).prop('checked',
                                    true);
                            }
                        }
                    }
                });
            });
            //Update Class
            $(document).on('click', '.btn-updateclass', function(e) {
                e.preventDefault();

                var updateclassid = $('#editclassid').val();
                var updatestatus = $('#edit_cr_status').is(':checked');
                var updatedeleted = $('#edit_cr_deleted').is(':checked');

                var data = {
                    'cr_name': $('#edit_cr_name').val(),
                    'cr_status': updatestatus == true ? '1' : '0',
                    'cr_deleted': updatedeleted == true ? '1' : '0',
                }
                $.ajax({
                    type: "put",
                    url: "/admin/updateclass/" + updateclassid,
                    data: data,
                    datatype: "json",
                    success: function(res) {
                        if (res.status == 200) {
                            $("#editclass").modal("hide");
                            $("#tableClass").load(location.href + " #tableClass");
                        }
                    }
                });
            });
            //Filter Status
            $("#filter_status").on("change", function(e) {
                e.preventDefault();
                var filterStatus = $(this).val();
                $.ajax({
                    type: "get",
                    url: "{{ route('admin.filterstatus') }}",
                    data: {
                        filterStatus: filterStatus,
                    },
                    success: function(res) {

                        $('tbody').html(res);
                        //console.log(res);

                        if (res.status == 400) {
                            Swal.fire({
                                icon: 'warning',
                                title: "Don't have with this status !!",
                            }).then((result) => {
                                $("#tableClass").load(location.href + " #tableClass");
                            })
                        }
                    }
                });
            });
            //get idclass
            $(document).on('click', '.btn-assignsubject', function(e) {
                e.preventDefault();

                var subid = $(this).val();
                $('#class_id').val(subid);

            });
            //Assign Subject
            $(document).on('click', '.btn-assign',function (e) {
                e.preventDefault();

                var data = {
                    'class_id' : $('#class_id').val(),
                    'as_create_by' :$('#as_create_by').val(),
                    'subject_id' : $('.class-room-assign').val(),
                }

                $.ajax({
                    type: "post",
                    url: "{{ route('admin.assign-subject') }}",
                    data: data,
                    datatype:'json',
                    success: function (res) {
                        if (res.status == 200) {
                            $("#assignsubject").modal('hide');
                            $("#form-as-subject")[0].reset();
                            
                            Swal.fire({
                                icon: 'success',
                                title: "Subjects has assign to clacc is Successfully",
                            });

                        }
                    }
                });

            });
        });
    </script>
@endsection
