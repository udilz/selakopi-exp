<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderLine;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pesananMasuk        = Order::where('status', '0')
            ->get()
            ->count();
        $pesananDihidangkan  = Order::where('status', '1')
            ->get()
            ->count();
        $pesananSelesai      = Order::where('status', '2')
            ->get()
            ->count();
        $orderLine           = OrderLine::orderBy('id', 'DESC')
            ->get();

        $order               = Order::orderBy('id', 'DESC')
            ->get();

        return view('backend.index', compact('pesananMasuk', 'pesananDihidangkan', 'pesananSelesai', 'orderLine', 'order'));
    }

    public function laporanPenjualan(Request $request)
    {
        $pesananMasuk        = Order::where('status', '0')
            ->get()
            ->count();
        $pesananDihidangkan  = Order::where('status', '1')
            ->get()
            ->count();
        $pesananSelesai      = Order::where('status', '2')
            ->get()
            ->count();

        $tanggalAwal    = $request->get('tanggalAwal');
        $tanggalAkhir   = $request->get('tanggalAkhir');

        $orderLine          = \App\Models\OrderLine::orderBy('id', 'DESC')
            ->whereDate('created_at', '>=', $tanggalAwal)
            ->whereDate('created_at', '<=', $tanggalAkhir)
            ->with('food')
            ->with('order')
            ->get();

        return view('backend.index', compact('tanggalAwal', 'tanggalAkhir', 'pesananMasuk', 'pesananDihidangkan', 'pesananSelesai', 'orderLine'));
    }
}
