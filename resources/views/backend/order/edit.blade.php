@extends('layouts.backend')

@section('title')
    Edit Orderan
@endsection

@section('pageTitle')
    Edit Orderan
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('orderan') }}" class="btn-sm btn btn-primary">
                            <i class="fas fa-backward" aria-hidden="true"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('orderan.update', [$order->id]) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="name">Nama Pengorder</label>
                                <input readonly value="{{ $order->name }}" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_meja">Nomor Meja</label>
                                <input readonly value="{{ $order->no_meja }}" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="item">Item + Quantity</label>
                                <textarea class="form-control" readonly  cols="10" rows="5">
                                    @foreach ($order->orderLine as $item)
                                        @if ($item->food->status != "Tidak Tersedia")
                                        {{ $item->qty }} {{ $item->food->name }}
                                        @endif
                                    @endforeach
                                </textarea>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status">Status Orderan</label>
                                    <select name="status" class="form-control">
                                        @if ($order->status == "0")
                                            <option selected value="0">Pesanan Masuk</option>
                                            <option value="1">Pesanan Di Hidangkan</option>
                                            <option value="2">Belum Bayar</option>
                                            <option value="3">Selesai</option>
                                        @elseif ($order->status == "1")
                                            <option value="0">Pesanan Masuk</option>
                                            <option selected value="1">Pesanan Di Hidangkan</option>
                                            <option value="2">Belum Bayar</option>
                                            <option value="3">Selesai</option>
                                        @elseif ($order->status == "2")
                                            <option value="0">Pesanan Masuk</option>
                                            <option >Pesanan Di Hidangkan</option>
                                            <option value="2" selected value="2">Belum Bayar</option>
                                            <option value="3">Selesai</option>
                                        @else
                                            <option value="0">Pesanan Masuk</option>
                                            <option value="1">Pesanan Di Hidangkan</option>
                                            <option value="2">Belum Bayar</option>
                                            <option selected value="3">Selesai</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-warning btn-block">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                    Update Data Orderan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
