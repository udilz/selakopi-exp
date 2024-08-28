<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Alert;


class OrderController extends Controller
{
    public function index()
    {
        $order = \App\Models\Order::orderBy('id', 'DESC')
            ->with('orderLine')
            ->get();
        $orderLine        = \App\Models\OrderLine::orderBy('id', 'DESC')
            ->with('food')
            ->with('order')
            ->get();
        return view('backend.order.index', compact('order', 'orderLine'));
    }

    public function pesananDihidangkan()
    {
        $order = \App\Models\Order::orderBy('id', 'DESC')
            ->with('orderLine')
            ->get();
        $orderLine        = \App\Models\OrderLine::orderBy('id', 'DESC')
            ->with('food')
            ->with('order')
            ->get();
        return view('backend.order.pesananDihidangkan', compact('order', 'orderLine'));
    }

    public function bayar()
    {
        $order = \App\Models\Order::orderBy('id', 'DESC')
            ->with('orderLine')
            ->get();
        $orderLine        = \App\Models\OrderLine::orderBy('id', 'DESC')
            ->with('food')
            ->with('order')
            ->get();
        return view('backend.order.bayar', compact('order', 'orderLine'));
    }

    public function pesananSelesai()
    {
        $order = \App\Models\Order::orderBy('id', 'DESC')
            ->with('orderLine')
            ->get();
        $orderLine        = \App\Models\OrderLine::orderBy('id', 'DESC')
            ->with('food')
            ->with('order')
            ->get();
        return view('backend.order.pesananSelesai', compact('order', 'orderLine'));
    }

    public function getLaporan(Request $request)
    {
        // $from   = $request->from . ' ' . '00:00:00';
        // $to     = $request->to   . ' ' . '23:59:59';

        // $order = \App\Models\Order::whereBetween('created_at', [$from, $to])
        //     ->get();

        $from       = $request->from;
        $to         = $request->to;

        $order      = \App\Models\Order::whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->orderBy('id', 'ASC')
            ->get();

        return view('backend.order.historyPenjualan', compact('order', 'from', 'to'));
    }

    public function no_meja($no_meja)
    {
        $tables = \App\Models\Table::groupBy('no_meja')
            ->orderBy('id', 'DESC')
            ->where('no_meja', $no_meja)
            ->first();
        $detailTables = \App\Models\Table::orderBy('id', 'DESC')
            ->where('no_meja', $no_meja)
            ->get();

        return view('backend.order.index', compact('tables', 'detailTables'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   =>    'required',
        ], [
            'name.required' => 'Field Nama Wajib Di Isi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 400,
                'error'     => $validator->errors()->toArray(),
            ]);
        } else {
            $order              = new \App\Models\Order;
            $order->name        = $request->get('name');
            $order->qty         = $request->get('qty');
            $order->qty         = $request->get('qty2');
            $order->status      = $request->get('status');
            $order->save();
            $order->tables()->attach($request->get('tables'));
            $order->foods()->attach($request->get('foods'));
            $order->drinks()->attach($request->get('drinks'));

            return response()->json([
                'status'    => 200,
                'message'   => 'Data Orderan Berhasil Di Kirm !',
            ]);
        }
    }

    public function edit($id)
    {
        $order      = \App\Models\Order::findOrFail($id);

        return view('backend.order.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order          = \App\Models\Order::findOrFail($id);
        $order->status  = $request->get('status');
        $order->update();
        Alert::success('Success', 'Status Orderan Berhasil Diperbaharui');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $order  = \App\Models\Order::findOrFail($id);
        $order->delete();

        ALert::success('Success', 'Data Orderan Berhasil Di Hapus !');
        return redirect()->route('orderan.pesananSelesai');
    }

    public function detail($id)
    {
        $order = \App\Models\Order::findOrFail($id);
        return view('backend.order.detail', compact('order'));
    }



    public function changeStatus($id)
    {
        $order = \App\Models\Order::findOrFail($id);

        if ($order->status == '0') {
            $change = '1';
        } elseif ($order->status == '1') {
            $change = '2';
        } elseif ($order->status == '2') {
            $change = '3';
        } else {
            $change = '0';
        }

        \App\Models\Order::where('id', $id)->update([
            'status'        => $change,
        ]);

        Alert::success('Success', 'Status Orderan Berhasil Di Perbaharui');
        return redirect()->back();
    }

    public function selectTables()
    {
        $tables = \App\Models\Table::all();
        return view('backend.order.selectTables', compact('tables'));
    }

    public function addOrderan()
    {
        $foods        = \App\Models\Food::orderBy('id', 'DESC')
            ->get();
        $categories    = \App\Models\Category::all();

        return view('backend.order.addOrderan', compact('foods', 'categories'));
    }

    public function storeOrderan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string',
            'no_meja' => 'required',
        ], [
            'name.required' => 'Field Nama Pemesan Wajib Di Isi !',
            'name.string'   => 'Field Nama Pemsan Harus Berformat Huruf !',
            'no_meja.required' => 'Filed Nomor Meja Wajib Di Isi !',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 400,
                'error'     => $validator->errors()->toArray(),
            ]);
        } else {
            try {
                $foods          = $request->get('foods');
                $tables         = $request->get('no_meja');
                $no_meja        = $request->get('no_meja');
                $qty            = $request->get('qty');
                $namaPemesan    = $request->get('name');
                $status         = $request->get('status');
                $id_orders      = \App\Models\Order::insertGetId([
                    'name'      => $namaPemesan,
                    'no_meja'   => $no_meja,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                foreach ($qty as $key => $qt) {
                    if ($qt == 0) {
                        continue;
                    }

                    $detailFoods = \App\Models\Food::where('id', $foods[$key])->first();
                    $harga_beli  = $detailFoods->harga_beli;
                    $subtotal    = $qt * $harga_beli;
                    $stock_now   = $detailFoods->minimal_stock;
                    $stock_new   = $stock_now - $qt;

                    \App\Models\Food::where('id', $foods[$key])->update([
                        'minimal_stock' => $stock_new
                    ]);

                    \App\Models\OrderLine::insert([
                        'orders'        => $id_orders,
                        'foods'         => $foods[$key],
                        'tables'        => $tables[$key],
                        'qty'           => $qt,
                        'harga_beli'    => $harga_beli,
                        'subtotal'      => $subtotal,
                        'status'        => $status,
                        'created_at'    => date('Y-m-d H:i:s'),
                        'updated_at'    => date('Y-m-d H:i:s'),
                    ]);
                }
            } catch (\Exception $e) {
                $e->getMessage();
            }

            return response()->json([
                'status'    => 200,
                'message'   => 'Data Orderan Anda Berhasil Di Kirim',
            ]);


            // return redirect()->back();
        }
    }
}
