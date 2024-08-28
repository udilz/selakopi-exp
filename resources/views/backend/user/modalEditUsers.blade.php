<div id="modalEditUsers" class="modal fade" tabindex="-1" aria-labelledby="modalEditUsersLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Edit Pengguna
                </h5>
                <button type="button" aria-label="Close"  data-dismiss="modal" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditUsers" action="{{ route('users.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="users_id" id="users_id">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nama Pengguna</label>
                                <input placeholder="Masukan Nama Pengguna" type="text" name="name" id="name_edit" class="form-control">
                                <span class="text-danger error-text name_error_edit"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input placeholder="Masukan Alamat Email" type="email" name="email" id="email_edit" class="form-control">
                                <span class="text-danger error-text email_error_edit"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">Roles</label>
                                <select name="roles" id="roles_edit" class="custom-select">
                                    <option value="#" selected>Pilih Roles</option>
                                    <option value="Admin">Administrator</option>
                                    <option value="Petugas">Petugas</option>
                                </select>
                                <span class="text-danger error-text roles_error_edit"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input placeholder="Masukan Password" type="password" name="password" id="password_edit" class="form-control">
                                <span class="text-danger error-text password_error_edit"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-warning">Update</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
