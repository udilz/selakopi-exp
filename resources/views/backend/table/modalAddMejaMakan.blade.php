<div id="modalAddMejaMakan" class="modal fade" tabindex="-1" aria-labelledby="AddMejaMakanLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Tambah Data Meja Makan
                </h5>
                <button type="button" data-dismiss="modal" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAddMejaMakan" class="form-add-meja-makan" action="{{ route('meja.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="no_meja_makan">Nomor Meja Makan</label>
                                <input type="number" name="no_meja" id="no_meja" class="form-control" placeholder="Masukan Nomor Meja Makan">
                                <span class="text-danger error-text no_meja_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">Status Meja Makan</label>
                                <select name="status" id="status" class="custom-select">
                                    <option value="Terisi">Terisi</option>
                                    <option value="Kosong">Kosong</option>
                                </select>
                                <span class="text-danger error-text status_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn-block btn btn-primary">
                                    <i class="fas fa-save"></i>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
