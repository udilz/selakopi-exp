<div id="modalAddMakanan" class="modal fade" tabindex="-1" aria-labelledby="AddMakananLabel" aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog-scrollable modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Tambah Data Makanan / Minuman
                </h5>
                <button type="button" data-dismiss="modal" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAddMakanan" class="form-add-makanan" action="{{ route('makanan.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama_makanan">Nama Makanan / Minuman</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Masukan Nama Makanan / Minuman">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="category_id">Kategori Makanan</label>
                                <select name="category_id" id="category_id" class="custom-select">
                                    <option value="#">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text status_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="foto">Foto Makanan</label>
                                <input type="file" name="photo" id="photo" class="form-control">
                                {{-- <span class="text-danger error-text photo_error"></span> --}}
                            </div>
                            <div class="img-holder">

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" name="harga_beli" id="harga_beli" class="form-control"
                                    placeholder="Masukan Harga Beli Makanan / Minuman">
                                <span class="text-danger error-text harga_beli_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" name="minimal_stock" id="minimal_stock" class="form-control"
                                    placeholder="Masukan Minimal Stock Makanan / Minuman">
                                <span class="text-danger error-text minimal_stock_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">Status Makanan</label>
                                <select name="status" id="status" class="custom-select">
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Tidak Tersedia">Tidak Tersedia</option>
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
