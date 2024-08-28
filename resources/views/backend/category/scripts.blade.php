<script>
    $(document).ready(function () {
        //token
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
            }
        });

        //fetch kategori
        function fetch_kategori ()
        {
            let datatable = $('#table_kategori').DataTable({
                processing: true,
                info: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('kategori.fetch') }}",
                    type: "GET",
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
        }
        fetch_kategori();

        //store kategori
        $(document).on('submit','#formAddkategori', function (e) {
            e.preventDefault();
            let dataForm = this;
            $.ajax({
                type: $('#formAddkategori').attr('method'),
                url: $('#formAddkategori').attr('action'),
                data: new FormData(dataForm),
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.form-kategori').find('span.error-text').text('');
                },
                success: function (response) {
                    if (response.status == 400) {
                        $.each(response.error, function (prefix, val) {
                            $('.form-kategori').find('span.'+prefix+'_error').text(val[0]);
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Kategori Baru Berhasil Di Tambahkan',
                            showConfirmButton: false,
                            timer: 1900
                        });
                        $('#modalAddKategori').modal('hide');
                        $('#table_kategori').DataTable().ajax.reload(null, false);
                        $('.form-kategori')[0].reset();
                    }
                }
            });
        });

        //edit kategori
        $(document).on('click','#btnEditKategori', function (e) {
            e.preventDefault();
            let category_id = $(this).data('id');
            $.get("{{ route('kategori.edit') }}", {category_id:category_id}, function (data) {
                $('#modalEditKategori').modal('show');
                $('#category_id').val(category_id);
                $('#name_edit').val(data.category.name);
            }, 'json');
        });

        //update kategori
        $(document).on('submit', '#formEditKategori', function (e) {
            e.preventDefault();
            let dataForm = this;
            $.ajax({
                type: $('#formEditKategori').attr('method'),
                url: $('#formEditKategori').attr('action'),
                data: new FormData(dataForm),
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.edit-kategori').find('span.error-text').text('');
                },
                success: function (response) {
                    if (response.status == 400) {
                        $.each(response.error, function (prefix, val) {
                            $('.edit-kategori').find('span.'+prefix+'_error_edit').text(val[0]);
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Kategori Berhasil Di Perbaharui',
                            showConfirmButton: false,
                            timer: 1900
                        });
                        $('#modalEditKategori').modal('hide');
                        $('#table_kategori').DataTable().ajax.reload(null, false);
                        $('.edit-kategori')[0].reset();
                    }
                }
            });
        });

        //delete kategori
        $(document).on('click', '#btnDeleteKategori', function (e) {
            e.preventDefault();
            let category_id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Kamu Yakin ?',
                text: "kamu Ingin Menghapus Data Kategori !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.post("{{ route('kategori.destroy') }}", {category_id:category_id}, function (data) {
                        Swal.fire(
                        'Deleted!',
                        data.message,
                        'success'
                        ),
                        $('#table_kategori').DataTable().ajax.reload(null, false);
                    },'json');
                }
            });
        });
    });
</script>
