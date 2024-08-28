@extends('layouts.backendDynamic')

@section('title')
    Orderan
@endsection

@section('pageTitle')
    Data Orderan
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h4 class="title">Filter Berdasarkan Status Pesanan</h5>
                        <hr class="my-3">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                                <a
                                    href=""
                                    class="nav-link active"
                                >
                                    Pesanan Masuk
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    href="{{ route('orderan.pesananDihidangkan') }}"
                                    class="nav-link"
                                >
                                    Pesanan Di Hidangkan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    href="{{ route('orderan.bayar') }}"
                                    class="nav-link"
                                >
                                    Bayar
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    href="{{ route('orderan.pesananSelesai') }}"
                                    class="nav-link"
                                >
                                    Selesai
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table id="table_status_orderan" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Status</th>
                                    <th>Nama Customer</th>
                                    <th>No Meja</th>
                                    <th>Item</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($order as $key => $item)
                                    @if ($item->status == '0')
                                        <tr>
                                            <td>
                                                {{ $no++ }}
                                            </td>
                                            <td>
                                                @if ($item->status == "0")
                                                        <a href="{{ route('orderan.changeStatus', $item->id) }}" class="badge badge-danger badge-pill">
                                                            Pesanan Masuk
                                                        </a>
                                                        <br>
                                                        {{ $item->created_at->format('d-M-Y H:i') }}
                                                    @elseif($item->status == "1")
                                                        <a href="{{ route('orderan.changeStatus', $item->id) }}" class="badge badge-primary badge-pill">
                                                            Pesanan Di Hidangkan
                                                        </a>
                                                        @elseif($item->status == "2")
                                                        <a href="{{ route('orderan.changeStatus', $item->id) }}" class="badge badge-primary badge-pill">
                                                            Pesanan Belum Dibayar
                                                        </a>

                                                    @else
                                                        <a href="{{ route('orderan.changeStatus', $item->id) }}" class="badge badge-success">
                                                            {{ $item->status }}
                                                        </a>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->name }}
                                            </td>
                                            <td>
                                                <span class="badge badge-warning">
                                                    #{{ $item->no_meja }}
                                                </span>
                                            </td>
                                            <td>
                                                @foreach ($item->orderLine as $v)
                                                        {{ $v->qty }} {{ $v->food->name }} <br>
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('orderan.edit', $item->id) }}" class="btn-sm btn btn-warning">
                                                        <i class="fas fa-edit" aria-hidden="true"></i>

                                                    </a>
                                                    @if ($item->status == '1')
                                                    <a href="{{ url('detail-orderan-pelanggan/no_meja/'.$item->no_meja.'/'.$item->name) }}" class="btn btn-success btn-sm">
                                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                                        {{-- Detail --}}
                                                    </a>
                                                    @endif
                                                    @if ($item->status == '2')
                                                    <form method="POST" onsubmit="return confirm('Apakah Kamu Yakin Ingin Menghapus Data Ini !')" action="{{ route('orderan.destroy', $item->id) }}">
                                                        @csrf
                                                        <button type="submit" class="btn-sm btn btn-danger">
                                                            <i class="fas fa-trash" aria-hidden="true"></i>
                                                            {{-- Delete --}}
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
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
@endsection

@section('footer-scripts')
    @include('backend.order.scriptsDynamic')
@endsection
