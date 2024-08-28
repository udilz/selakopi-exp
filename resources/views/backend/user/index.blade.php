@extends('layouts.backend')

@section('title')
    Users
@endsection

@section('pageTitle')
    Data Pengguna
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddUsers">
                        <i class="fas fa-plus"></i>
                        Tambah Pengguna
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table id="table_users" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modal --}}
@include('backend.user.modalAddUsers')
@include('backend.user.modalEditUsers')
@endsection

@section('footer-scripts')
<script>
    $(document).ready(function () {
        //token
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
            }
        });

        //ajax fech users;
        function fetchUsers()
        {
            let datatable = $('#table_users').DataTable({
                processing: true,
                info: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.fetch') }}",
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'roles',
                        name: 'roles'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });
        }
        fetchUsers();

        //store users;
        $(document).on('submit', '#formAddUsers', function (e) {
            e.preventDefault();
            let dataForm = this;
            $.ajax({
                type: $('#formAddUsers').attr('method'),
                url: $('#formAddUsers').attr('action'),
                data: new FormData(dataForm),
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#formAddUsers').find('span.error-text').text('');
                },
                success: function (response) {
                    if (response.status == 400)
                    {
                        $.each(response.error, function (prefix, val) {
                            $('#formAddUsers').find('span.'+prefix+'_error').text(val[0]);
                        });
                    }
                    else
                    {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1900
                        });
                        $('#modalAddUsers').modal('hide');
                        $('#table_users').DataTable().ajax.reload(null, false);
                        $('#formAddUsers')[0].reset();
                    }
                }
            });
        });

        //edit users;
        $(document).on('click', '#btnEditUsers', function (e) {
            e.preventDefault();
            let users_id = $(this).data('id');
            $.get("{{ route('users.update') }}", {users_id:users_id},
                function (data) {
                    $('#modalEditUsers').modal('show');
                    $('#users_id').val(users_id);
                    $('#name_edit').val(data.users.name);
                    $('#email_edit').val(data.users.email);
                    $('#roles_edit').val(data.users.roles);
                },
                "json"
            );
        });

        //update users;
        $(document).on('submit', '#formEditUsers', function (e) {
            e.preventDefault();
            let dataForm = this;
            $.ajax({
                type: $('#formEditUsers').attr('method'),
                url: $('#formEditUsers').attr('action'),
                data: new FormData(dataForm),
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#formEditUsers').find('span.error-text').text('');
                },
                success: function (response) {
                    if (response.status == 400)
                    {
                        $.each(response.error, function (prefix, val) {
                            $('#formEditUsers').find('span.'+prefix+'_error_edit').text(val[0]);
                        });
                    }
                    else
                    {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1900
                        });
                        $('#modalEditUsers').modal('hide');
                        $('#table_users').DataTable().ajax.reload(null, false);
                        $('#formEditUsers')[0].reset();
                    }
                }
            });
        });

        //destroy users
        $(document).on('click', '#btnDeleteUsers', function (e) {
            e.preventDefault();
            let users_id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Kamu Yakin ?',
                text: "kamu Ingin Menghapus Data Pengguna !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("{{ route('users.destroy') }}", {users_id:users_id},
                            function (data) {
                                Swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                ),
                                $('#table_users').DataTable().ajax.reload(null, false);
                            },
                            "json"
                        );
                    }
                });
        });
    });
</script>
@endsection
