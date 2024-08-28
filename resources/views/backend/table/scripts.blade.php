<script>
    $(document).ready(function () {
        //token
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
            }
        });

        //ajax fetch meja makan;
        function fetch_meja_makan ()
        {
            let datatable = $('#table_meja_makan').DataTable({
                processing: true,
                info: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('meja.fetch') }}",
                    type: "GET",
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'no_meja',
                        name: 'no_meja'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });
        }
        fetch_meja_makan();

        //ajax store meja makan;
        $(document).on('submit','#formAddMejaMakan', function (e) {
            e.preventDefault();
            let dataForm = this;
            $.ajax({
                type: $('#formAddMejaMakan').attr('method'),
                url: $('#formAddMejaMakan').attr('action'),
                data: new FormData(dataForm),
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.form-add-meja-makan').find('span.error-text').text('');
                },
                success: function (response) {
                    if (response.status == 400) {
                        $.each(response.error, function (prefix, val) {
                            $('.form-add-meja-makan').find('span.'+prefix+'_error').text(val[0]);
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1900
                        });
                        $('#modalAddMejaMakan').modal('hide');
                        $('#table_meja_makan').DataTable().ajax.reload(null, false);
                        $('.form-add-meja-makan')[0].reset();
                    }
                }
            });
        });

        //ajax edit meja makan;
        $(document).on('click', '#btnEditMejaMakan', function (e) {
            e.preventDefault();
            let table_id = $(this).data('id');
            $.get("{{ route('meja.edit') }}", {table_id:table_id},
                function (data) {
                    $('#modalEditMejaMakan').modal('show');
                    $('#table_id').val(table_id);
                    $('#no_meja_edit').val(data.table.no_meja);
                    $('#status_edit').val(data.table.status);
                },
                "json"
            );
        });

        //ajax update meja makan;
        $(document).on('submit', '#formEditMejaMakan', function (e) {
            e.preventDefault();
            let dataForm = this;
            $.ajax({
                type: $('#formEditMejaMakan').attr('method'),
                url: $('#formEditMejaMakan').attr('action'),
                data: new FormData(dataForm),
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.form-edit-meja-makan').find('span.error-text').text('');
                },
                success: function (response) {
                    if (response.status == 400) {
                        $.each(response.error, function (prefix, val) {
                            $('.form-edit-meja-makan').find('span.'+prefix+'_error_edit').text(val[0]);
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#modalEditMejaMakan').modal('hide');
                        $('#table_meja_makan').DataTable().ajax.reload(null, false);
                        $('.form-edit-meja-makan')[0].reset();
                    }
                }
            });
        });

        //ajax delete meja makan;
        $(document).on('click', '#btnDeleteMejaMakan', function (e) {
            e.preventDefault();
            let table_id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Kamu Yakin ?',
                text: "kamu Ingin Menghapus Data Meja Makan !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.post("{{ route('meja.destroy') }}", {table_id:table_id}, function (data) {
                        Swal.fire(
                        'Deleted!',
                        data.message,
                        'success'
                        ),
                        $('#table_meja_makan').DataTable().ajax.reload(null, false);
                    },'json');
                }
            });
        });
    });
</script>
