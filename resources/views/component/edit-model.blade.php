
<div class="modal fade" id="edituser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">EditUser</h5>
        </div>
        <form method="post" id="formEditUser" enctype="multipart/form-data">
            <input type="hidden" id="editUserID">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="edit_name" name="name">
                <label for="name">Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="edit_email" name="email">
                <label for="email">Your Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="edit_password" name="password">
                <label for="password">Password</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="edit_role" name="role"
                    aria-label="Floating label select example">
                    <option selected>Select Role</option>
                    <option value="1">Admin</option>
                    <option value="2">Teacher</option>
                    <option value="3">Student</option>
                    <option value="3">Parent</option>
                </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary btn-updateuser">Update</button>
            </div>
        </form>
      </div>
    </div>
  </div>