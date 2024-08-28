@extends('layouts.tables.dynamic')

@section('title')
    Status Orderan
@endsection

@section('content')
    <div class="container">
        <div class="row" style="margin-top: 50px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-warning text-white text-uppercase text-center">
                        <h4>Status Orderan No Meja {{ $tables->no_meja }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="table_status_orderan" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Order</th>
                                            <th>Status</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $item)
                                            @if ($tables->no_meja == $item->no_meja)
                                                @if ($item->status != '3')
                                                    <tr>
                                                        <td>
                                                            {{ $key + 1 }}
                                                        </td>
                                                        <td>
                                                            @foreach ($item->orderLine as $v)
                                                                {{ $v->qty }} {{ $v->food->name }} <br>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @if ($item->status == '0')
                                                                <span class="badge badge-danger badge-pill">
                                                                    Pesanan Anda Sedang Disiapkan !
                                                                </span>
                                                            @elseif($item->status == '1')
                                                                <span class="badge badge-primary badge-pill">
                                                                    Selamat Menikmati Hidangan
                                                                </span>
                                                            @elseif($item->status == '2')
                                                                <span class="badge badge-primary badge-pill">
                                                                    Pesanan Belum Dibayar
                                                                </span>
                                                            @else
                                                                <span class="badge badge-success badge-pill">
                                                                    Selesai
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                $totalPrice = 0;
                                                            @endphp
                                                            @foreach ($item->orderLine as $v)
                                                                @php
                                                                    $totalPrice += $v->subtotal;
                                                                @endphp
                                                            @endforeach
                                                            Rp. {{ number_format($totalPrice, 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <a href="{{ route('pelanggan.meja1', $tables->no_meja) }}" class="item-link" onclick="select(this)"><button
            type="button" class="btn btn-dark mt-2">Back To Menu</button></a>
@endsection



@section('footer-scripts')
    @include('frontend.order.scriptDynamic')
@endsection
