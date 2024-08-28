@extends('layouts.backend')

@section('title')
    Kategori
@endsection

@section('pageTitle')
    Kategori Menu
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddKategori">
                            <i class="fas fa-plus"></i>
                            Tambah Data Kategori
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table id="table_kategori" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Kategori</th>
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

    {{-- AddKategoriModal --}}
    @include('backend.category.modalAddKategori')
    {{-- EditKategoriModal --}}
    @include('backend.category.modalEditKategori')
@endsection

@section('footer-scripts')
    @include('backend.category.scripts')
@endsection
