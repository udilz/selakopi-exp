@extends('layouts.backend')

@section('title')
    Meja Makanan
@endsection

@section('pageTitle')
    Data Meja Makanan
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddMejaMakan">
                        <i class="fas fa-plus"></i>
                        Tambah Meja Makan
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table id="table_meja_makan" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No Meja</th>
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

{{-- Modal AddMejaMakan --}}
@include('backend.table.modalAddMejaMakan')
{{-- Modal EditMejaMakan --}}
@include('backend.table.modalEditMejaMakan')

@endsection

@section('footer-scripts')
    @include('backend.table.scripts')
@endsection
