<div id="modalEditKategori" class="modal fade" aria-labelledby="EditKategoriLabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Edit Data Kategori
                </h5>
                <button type="button" class="close" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditKategori" class="edit-kategori" action="{{ route('kategori.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="category_id" id="category_id">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Nama Kategori">Nama Kategori</label>
                                <input type="text" name="name" id="name_edit" class="form-control">
                                <span class="text-danger error-text name_error_edit"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-warning btn-block">
                                    <i class="far fa-edit"></i>
                                    Edit Kategori
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
