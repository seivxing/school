
<div class="modal fade" id="addnewclass" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">EditUser</h5>
        </div>
        <form method="post" id="formaddnewclass" enctype="multipart/form-data">
            <input type="hidden" id="editUserID">
            @csrf
            <div class="form-floating mb-3">
                <input type="hidden" class="form-control" id="cr_create_by" name="cr_create_by" value="{{ Auth::user()->id }}">
                <label for="name" class="form-label">Class Name</label>
                <input type="text" class="form-control" id="cr_name" name="cr_name">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary btn-addclass">Add</button>
            </div>
        </form>
      </div>
    </div>
  </div>