<script>
    $(document).ready(function() {
        //token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        function fetch_makanan(foodByCategory = '') {
            let datatable = $('#table_makanan').DataTable({
                processing: true,
                info: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('makanan.fetch') }}",
                    data: {
                        foodByCategory: foodByCategory
                    },
                    type: "GET",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'photo',
                        name: 'photo',
                    },
                    {
                        data: 'harga_beli',
                        name: 'harga_beli',
                    },
                    {
                        data: 'status', // Menampilkan status
                        name: 'status',
                        render: function(data, type, full,
                        meta) { // Gunakan render untuk menyesuaikan tampilan data
                            if (full.minimal_stock == 0) { // Jika minimal_stock 0
                                return 'Tidak Tersedia'; // Tampilkan Tidak Tersedia
                            } else {
                                return data; // Tampilkan status yang diambil dari data
                            }
                        }
                    },
                    {
                        data: 'minimal_stock',
                        name: 'minimal_stock',
                    },
                    {
                        data: 'kategori',
                        name: 'kategori',
                    },
                    {
                        data: 'action',
                        name: 'action',
                    },
                ],
            });
        }
        fetch_makanan();

        //filter kategori makanan & minuman
        $(document).on('click', '#filter', function(e) {
            e.preventDefault();
            let foodByCategory = $('#foodByCategory').val();
            if (foodByCategory != '') {
                $('#table_makanan').DataTable().destroy();
                fetch_makanan(foodByCategory);
            } else {
                alert('Pilih Kategori Telebih Dahulu !');
            }
        });

        $(document).on('click', '#reset', function(e) {
            e.preventDefault();
            $('#foodByCategory').val('');
            $('#table_makanan').DataTable().destroy();
            fetch_makanan();
        });

           //store food
           $(document).on('submit','#formAddMakanan', function (e) {
            e.preventDefault();
            let dataForm = this;
            $.ajax({
                type: $('#formAddMakanan').attr('method'),
                url: $('#formAddMakanan').attr('action'),
                data: new FormData(dataForm),
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.form-add-makanan').find('span.error-text').text('');
                },
                success: function (response) {
                    if (response.status == 400) {
                        $.each(response.error, function (prefix, val) {
                            $('.form-add-makanan').find('span.'+prefix+'_error').text(val[0]);
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Kategori Baru Berhasil Di Tambahkan',
                            showConfirmButton: false,
                            timer: 1900
                        });
                        $('#modalAddMakanan').modal('hide');
                        $('#table_makanan').DataTable().ajax.reload(null, false);
                        $('.form-add-makanan')[0].reset();
                    }
                }
            });
        });

        //preview foto makanan
        $('input[type="file"][name="photo"]').val('');
        $('input[type="file"][name="photo"]').on('change', function(e) {
            e.preventDefault();
            file_path = $(this)[0].value;
            img_holder = $('.img-holder');
            extension = file_path.substring(file_path.lastIndexOf('.') + 1).toLowerCase();

            if (extension == 'jpg' || extension == 'jpeg' || extension == 'png') {
                if (typeof(FileReader) != 'undefined') {
                    img_holder.empty();
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('<img/>', {
                            'src': e.target.result,
                            'class': 'img-fluid',
                            'style': 'max-width:100px;margin-bottom:10px'
                        }).appendTo(img_holder);
                    }
                    img_holder.show();
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    $(img_holder).html('Browser Ini Tidak Support File Reader !');
                }
            } else {
                img_holder.empty();
            }
        });


        //preview foto makanan edit
        $('input[type="file"][name="photo_edit"]').val('');
        $('input[type="file"][name="photo_edit"]').on('change', function(e) {
            e.preventDefault();
            file_path = $(this)[0].value;
            img_holder = $('.img-holder-edit');
            extension = file_path.substring(file_path.lastIndexOf('.') + 1).toLowerCase();

            if (extension == 'jpg' || extension == 'jpeg' || extension == 'png') {
                if (typeof(FileReader) != 'undefined') {
                    img_holder.empty();
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('<img/>', {
                            'src': e.target.result,
                            'class': 'img-fluid',
                            'style': 'max-width:100px;margin-bottom:10px'
                        }).appendTo(img_holder);
                    }
                    img_holder.show();
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    $(img_holder).html('Browser Ini Tidak Support File Reader !');
                }
            } else {
                img_holder.empty();
            }
        });

        //ajax edit makanan dan minuman
        $(document).on('click', '#btnEditMakanan', function(e) {
            e.preventDefault();
            let food_id = $(this).data('id');
            $.get("{{ route('makanan.edit') }}", {
                    food_id: food_id
                },
                function(data) {
                    $('#modalEditMakanan').modal('show');
                    $('#food_id').val(food_id);
                    $('#name_edit').val(data.food.name);
                    $('#category_id_edit').val(data.food.category_id);
                    $('#tmp_photo').val(data.food.photo);
                    $('#harga_jual_edit').val(data.food.harga_jual);
                    $('#harga_beli_edit').val(data.food.harga_beli);
                    $('#stock_edit').val(data.food.stock);
                    $('#minimal_stock_edit').val(data.food.minimal_stock);
                    $('#status_edit').val(data.food.status);
                    $('#kode_edit').val(data.food.kode);
                },
                "json"
            );
        });

        // ajax update makanan dan minuman
        $(document).on('submit', '#formEditMakanan', function(e) {
            e.preventDefault();
            let dataForm = this;
            $.ajax({
                type: $('#formEditMakanan').attr('method'),
                url: $('#formEditMakanan').attr('action'),
                data: new FormData(dataForm),
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.form-edit-makanan').find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val) {
                            $('.form-edit-makanan').find('span.' + prefix +
                                '_error_edit').text(val[0]);
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1900
                        });
                        $('#modalEditMakanan').modal('hide');
                        $('#table_makanan').DataTable().ajax.reload(null, false);
                        $('.form-edit-makanan')[0].reset();
                    }
                }
            });
        });

        //ajax delete makanan dan minuman
        $(document).on('click', '#btnDeleteMakanan', function(e) {
            e.preventDefault();
            let food_id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Kamu Yakin ?',
                text: "kamu Ingin Menghapus Data Makanan / Minuman !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("{{ route('makanan.destroy') }}", {
                        food_id: food_id
                    }, function(data) {
                        Swal.fire(
                                'Deleted!',
                                data.message,
                                'success'
                            ),
                            $('#table_makanan').DataTable().ajax.reload(null, false);
                    }, 'json');
                }
            });
        });

    });
</script>
