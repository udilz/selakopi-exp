@extends('layouts.backend')

@section('title')
    Dashboard
@endsection

@section('pageTitle')
    Dashboard
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $pesananMasuk }}</h3>
                <p>Pesanan Masuk</p>
                </div>
                <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('orderan') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $pesananDihidangkan }}</h3>
                <p>Pesanan Dihidangkan</p>
                </div>
                <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('orderan.pesananDihidangkan') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pesananSelesai }}</h3>

                <p>Pesanan Selesai</p>
                </div>
                <div class="icon">
                <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('orderan.pesananSelesai') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                @php
                    $totalPendapatan = 0;
                @endphp
                @foreach ($orderLine as $item)
                    @if ($item->order->status != "2")

                    @else
                        @php
                            $totalPendapatan = $totalPendapatan + $item->subtotal;
                        @endphp
                    @endif
                @endforeach
                <h3>
                    Rp. {{ number_format($totalPendapatan,0,",",".") }}
                </h3>

                <p>Total Pendapatan</p>
                </div>
                <div class="icon">
                <i class="ion ion-pie-graph"></i>
                </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->
<div class="card">
    <div class="card-header">
        <h3 class="title">Filter Laporan Penjualan</h3>
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col-md-12">
                <form action="{{ route('dashboard.laporanPenjualan') }}" method="GET">
                    {{-- @csrf --}}
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text"
                                    name="tanggalAwal"
                                    class="form-control"
                                    placeholder="Tangal Awal"
                                    onfocusin="(this.type='date')"
                                    onfocusout="(this.type='text')"
                                    value=""
                                    required
                                />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text"
                                    name="tanggalAkhir"
                                    value=""
                                    class="form-control"
                                    placeholder="Tangal Akhir"
                                    onfocusin="(this.type='date')"
                                    onfocusout="(this.type='text')"
                                    required
                                />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary">
                                    <span class="fas fa-search"></span>
                                    Cari
                                </button>
                                <button type="button" class="btn btn-success" onclick="tablesToExcel(['table_status_orderan3'], ['Report'], 'Laporan_penjualan.xls', 'Excel')">
                                    <span class="fas fa-table"></span>
                                    Export Data
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-warning">
                                    <span class="fa fa-refresh"></span>
                                    Segarkan
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table id="table_status_orderan3" class="table table-condensed table-striped table2excel">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengorder</th>
                            <th>Meja</th>
                            <th>Item</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                            $grandTotal = 0;
                        @endphp
                        @foreach ($orderLine as $key => $item)
                            @if ($item->order->status == '2')
                                <tr>
                                    <td>
                                        {{ $no++ }}
                                    </td>
                                    <td>
                                        {{ $item->order->name }}
                                    </td>
                                    <td>
                                        {{ $item->order->no_meja }}
                                    </td>
                                    <td>
                                        {{ $item->food->name }}
                                    </td>
                                    <td>
                                        {{ $item->food->harga_beli }}
                                    </td>
                                    <td>
                                        {{ $item->qty }}
                                    </td>
                                    <td>
                                        {{ $item->subtotal }}
                                    </td>
                                    <td>
                                        {{ $item->order->created_at }}
                                    </td>
                                    <td>
                                        @if ($item->order->status == '0')
                                            Pesanan Masuk
                                        @elseif ($item->order->status == '1')
                                            Pesanan Dihidangkan
                                        @else
                                            Selesai
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>

                </table>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th>Grand Total</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>:</th>
                            <th>
                                @php
                                    $grandQty = 0;
                                @endphp
                                @foreach ($orderLine as $item)
                                    @if ($item->order->status == '2')
                                        @php
                                            $grandQty += $item->qty;
                                        @endphp
                                    @endif
                                @endforeach
                                {{ $grandQty }} Qty
                            </th>
                            <th>
                                @php
                                    $grandTotal = 0;
                                @endphp
                                @foreach ($orderLine as $item)
                                    @if ($item->order->status == '2')
                                        @php
                                            $grandTotal += $item->subtotal;
                                        @endphp
                                    @endif
                                @endforeach
                                Rp. {{ number_format($grandTotal,0,",",".") }}
                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    <script>
            $('#table_status_orderan3').DataTable({
                responsive: true,
                lengthCase: true,
                autoWidth:true,
                paging:true,
                searching:true,
                ordering:true,
                info:true,
        });
    </script>
@endsection
