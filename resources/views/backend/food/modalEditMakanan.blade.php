<div id="modalEditMakanan" class="modal fade" tabindex="-1" aria-labelledby="AddMakananLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog-scrollable modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Edit Data Makanan / Minuman
                </h5>
                <button type="button" data-dismiss="modal" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditMakanan" class="form-edit-makanan" action="{{ route('makanan.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="food_id" id="food_id">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama_makanan">Nama Makanan / Minuman</label>
                                <input type="text" name="name" id="name_edit" class="form-control" placeholder="Masukan Nama Makanan / Minuman">
                                <span class="text-danger error-text name_error_edit"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="category_id">Kategori Makanan</label>
                                <select name="category_id" id="category_id_edit" class="custom-select">
                                    <option value="#">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text category_id_error_edit"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="foto">Foto Makanan</label>
                                <input type="file" name="photo_edit" id="photo_edit" class="form-control">
                                <input type="hidden" name="tmp_photo" id="tmp_photo" class="form-control">
                                <span class="text-danger error-text photo_error_edit"></span>
                            </div>
                            <div class="img-holder-edit">

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" name="harga_beli" id="harga_beli_edit" class="form-control"
                                    placeholder="Masukan Harga Beli Makanan / Minuman">
                                <span class="text-danger error-text harga_beli_error_edit"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" name="minimal_stock" id="minimal_stock_edit" class="form-control"
                                    placeholder="Masukan Minimal Stock Makanan / Minuman">
                                <span class="text-danger error-text minimal_stock_error_edit"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">Status Makanan</label>
                                <select name="status" id="status_edit" class="custom-select">
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Tidak Tersedia">Tidak Tersedia</option>
                                </select>
                                <span class="text-danger error-text status_error_edit"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn-block btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                    Edit Makanan / Minuman
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
