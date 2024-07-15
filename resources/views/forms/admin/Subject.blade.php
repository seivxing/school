@extends('component.app')

@section('subject', 'active')
@include('component.edit-subject-model')
@include('component.add-new-subject-model')
@section('content')
    <div class="bg-light rounded h-100 p-4">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addnewsubject">New Subject</button>
        <div class="table-responsive">
            <table class="table" id="tableSubject">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Subject Type</th>
                        <th scope="col">Create</th>
                        <th scope="col">Status</th>
                        <th scope="col">Delete</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($getdata as $data)
                        <tr>
                            <th scope="row">{{ $data->id }}</th>
                            <td>{{ $data->sub_name }}</td>
                            <td>{{ $data->sub_type }}</td>
                            <td>{{ $data->getUser->name }}</td>
                            <td>
                                @if ($data->sub_status == 1)
                                    <div class="text-primary">Active</div>
                                @else
                                    <div class="text-danger">Inactive</div>
                                @endif
                            </td>
                            <td>
                                @if ($data->sub_delete == 1)
                                    <div class="text-success">Is Deleted</div>
                                @else
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success btn-editsubject" data-bs-toggle="modal"
                                    data-bs-target="#editsubject" value="{{ $data->id }}">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <span class="border">
            <div class="m-1">
                <h4>list Class</h4>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach ($assignsubject as $data)
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Class: {{ $data->getClassid_foreignkey->cr_name }}</h5>
                                    <p class="card-text">Subject: {{$data->getSubjectid_foreignkey->sub_name}}</p>
                                    <p class="card-text">CreateBY: {{$data->getuserid_foreignkey->name}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </span>
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
            
            //Ceate Subject
            $(document).on("click", ".btn-addnewsubject", function(e) {
                e.preventDefault();

                var data = {
                    'sub_name': $('#sub_name').val(),
                    'sub_create': $('#sub_create').val(),
                    'sub_type': $('#sub_type').val(),
                }
                $.ajax({
                    type: "post",
                    url: "{{ route('admin.addsubject') }}",
                    data: data,
                    datatype: "json",
                    success: function(res) {
                        if (res.status == 200) {
                            $("#addnewsubject").modal('hide');
                            $("#formaddsubject")[0].reset();
                            $("#tableSubject").load(location.href + " #tableSubject");

                            Swal.fire({
                                icon: 'success',
                                title: "Subject Create Successfully",
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
            //Edit Subject
            $(document).on("click", ".btn-editsubject", function(e) {
                e.preventDefault();
                var subjectid = $(this).val();
                $('#editsubjectid').val(subjectid);

                $.ajax({
                    type: "get",
                    url: "/admin/editsubject/" + subjectid,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#edit_sub_name').val(res.data.sub_name);
                            if (res.data.sub_status == 1) {
                                $('#edit_sub_status').val(res.data.sub_status).prop('checked',
                                    true);
                            }
                            if (res.data.sub_delete == 1) {
                                $('#edit_sub_delete').val(res.data.sub_delete).prop('checked',
                                    true);
                            }
                        }
                    }
                });
            });
            // //Update Subject
            $(document).on("click", ".btn-updatesubject", function(e) {
                e.preventDefault();

                var updatesubjectid = $('#editsubjectid').val();
                var updatestatus = $('#edit_sub_status').is(':checked');
                var updatedelete = $('#edit_sub_delete').is(':checked');

                var data = {
                    'sub_name': $('#edit_sub_name').val(),
                    'sub_status': updatestatus == true ? '1' : '0',
                    'sub_delete': updatedelete == true ? '1' : '0',
                }
                $.ajax({
                    type: "put",
                    url: "/admin/updatesubject/" + updatesubjectid,
                    data: data,
                    dataType: "json",
                    success: function(res) {
                        if (res.status == 200) {
                            $("#editsubject").modal("hide");
                            $("#tableSubject").load(location.href + " #tableSubject");
                        }
                    }
                });
            });
            // //Filter Status
            // $("#filter_status").on("change", function(e) {
            //     e.preventDefault();
            //     var filterStatus = $(this).val();
            //     $.ajax({
            //         type: "get",
            //         url: "{{ route('admin.filterstatus') }}",
            //         data: {
            //             filterStatus: filterStatus,
            //         },
            //         success: function(res) {

            //             $('tbody').html(res);
            //             //console.log(res);

            //             if (res.status == 400) {
            //                 Swal.fire({
            //                     icon: 'warning',
            //                     title: "Don't have with this status !!",
            //                 }).then((result) => {
            //                     $("#tableClass").load(location.href + " #tableClass");
            //                 })
            //             }
            //         }
            //     });
            // });
        });
    </script>
@endsection
