<div class="modal fade" id="editstudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">EditStudent</h5>
            </div>
            <form method="post" id="formeditstudent" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <input type="hidden" id="editstudentID">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="updatefname" name="updatefname">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="updatelname" name="updatelname">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="updatedob" name="updatedob">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="updatephone" name="updatephone" maxlength="12">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select form-select-sm" name="updategender" id="updategender">
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Other</option>
                    </select>
                    <div class="mb-3">
                        <label for="profile" class="form-label">Profile</label>
                        <input class="form-control" type="file" id="updateprofile" name="updateprofile">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-updatestudent">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
