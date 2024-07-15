<div class="modal fade" id="editclass" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">EditUser</h5>
            </div>
            <form method="post" id="formEditClass" enctype="multipart/form-data">
                <div class="container">
                    <input type="hidden" id="editclassid">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="edit_cr_name" name="cr_name">
                        <label for="name">Name</label>
                    </div>
                    <div class="mb-2 d-flex gap-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="edit_cr_status"
                                name="cr_status">
                            <label class="form-check-label">Action</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="edit_cr_deleted"
                                name="cr_deleted">
                            <label class="form-check-label">Delete</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-updateclass">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
