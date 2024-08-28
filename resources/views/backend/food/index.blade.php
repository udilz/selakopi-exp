@extends('layouts.backend')

@section('title')
    Makanan
@endsection

@section('pageTitle')
    Data Menu Makanan
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="title">Filter By Kategori</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="foodByCategory" id="foodByCategory" class="custom-select" required>
                                    <option value="">Pilih Kategori Makanan & Minuman</option>
                                    @foreach ($food as $item)
                                        <option value="{{ $item->category_id }}">
                                            {{ $item->categories->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="button" name="filter" id="filter" class="btn btn-info">
                                    <span class="fas fa-search"></span>
                                    Cari
                                </button>
                                <button type="button" name="reset" id="reset" class="btn btn-warning">
                                    <span class="fa fa-refresh"></span>
                                    Semua Kategori
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary float-md-right" data-toggle="modal"
                                data-target="#modalAddMakanan">
                                <i class="fas fa-plus"></i>
                                Tambah Makanan / Minuman
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table id="table_makanan" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Makanan</th>
                                        <th>Foto</th>
                                        <th>Harga Beli</th>
                                        <th>Status</th>
                                        <th>Stock</th>
                                        <th>Kategori</th>
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

    {{-- modalAddMakanan --}}
    @include('backend.food.modalAddMakanan')
    {{-- modalEditMakanan --}}
    @include('backend.food.modalEditMakanan')
@endsection

@section('footer-scripts')
    @include('backend.food.scripts')
@endsection
