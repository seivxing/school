
<div class="modal fade" id="assignsubject" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Assign</h5>
        </div>
        <form method="post" id="form-as-subject" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <input type="hidden" id="class_id" name="class_id">
              <input type="hidden" id="as_create_by" name="as_create_by" value="{{ Auth::user()->id }}">
              <select class="class-room-assign form-select" id="subjectid" name="subjectid[]" multiple="multiple">
                @foreach ($getdatasubject as $data)
                <option value="{{$data->id}}">{{$data->sub_name}}</option>
                @endforeach
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary btn-assign">Add</button>
            </div>
        </form>
      </div>
    </div>
  </div>