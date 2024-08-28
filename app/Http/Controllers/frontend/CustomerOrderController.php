<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerOrderController extends Controller
{
    public function meja1($no_meja)
    {
        $tables = \App\Models\Table::groupBy('no_meja')->orderBy('id', 'DESC')->where('no_meja', $no_meja)->first();
        $detailTables = \App\Models\Table::orderBy('id', 'DESC')->where('no_meja', $no_meja)->get();
        $foods = \App\Models\Food::orderBy('id', 'DESC')->get();
        $categories = \App\Models\Category::all();

        return view('frontend.order.meja1', compact('tables', 'detailTables', 'foods', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'foods.*' => 'required|exists:foods,id',

            ],
            [
                'name.required' => 'Field Nama Pemesan Wajib Di Isi!',
                'name.string' => 'Field Nama Pemsan Harus Berformat Huruf!',
                'foods.*.required' => 'Setiap item makanan harus dipilih.',
                'foods.*.exists' => 'Item makanan yang dipilih tidak valid.',
            ],
        );

        // Jika validasi gagal, kembalikan respons dengan pesan kesalahan
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ]);
        } else {
            // Jika validasi sukses, mulai transaksi database
            DB::beginTransaction();
            try {
                // Memproses setiap item makanan yang dipesan
                $foods = $request->get('foods');
                $tables = $request->get('tables');
                $no_meja = $request->get('no_meja');
                $qty = $request->get('qty');
                $namaPemesan = $request->get('name');
                $status = $request->get('status');

                // Memasukkan data order ke dalam tabel orders
                $id_orders = \App\Models\Order::insertGetId([
                    'name' => $namaPemesan,
                    'status' => $status,
                    'no_meja' => $no_meja,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                foreach ($qty as $key => $qt) {
                    if ($qt == 0) {
                        continue; // Item dengan qty 0 tidak diolah
                    }
                    // Mengambil informasi makanan dari database
                    $food = \App\Models\Food::where('id', $foods[$key])->first();
                    $harga_beli = $food->harga_beli;
                    $subtotal = $qt * $harga_beli;
                    $stock_now = $food->minimal_stock;
                    $stock_new = $stock_now - $qt;

                    // Memeriksa apakah stok mencukupi
                    if ($stock_new < 0) {
                        return response()->json([
                            'status' => 500,
                            'message' => 'Stok ' . $food->name . ' Habis.',
                        ]);
                    }

                    // Mengupdate stok makanan setelah pesanan dibuat
                    $food->update([
                        'minimal_stock' => $stock_new,
                    ]);

                    // Simpan order ke dalam tabel orders
                    DB::commit();

                    // Memasukkan detail pesanan ke dalam tabel order_lines
                    \App\Models\OrderLine::insert([
                        'orders' => $id_orders,
                        'foods' => $foods[$key],
                        'tables' => $tables[$key],
                        'qty' => $qt,
                        'harga_beli' => $harga_beli,
                        'subtotal' => $subtotal,
                        // 'status'        => $status,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            } catch (\Exception $e) {
                // Rollback transaksi jika terjadi kesalahan
                DB::rollback();
                return response()->json([
                    'status' => 500,
                    'message' => 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage(),
                ]);
            }

            // Jika semua proses berhasil, kembalikan respons sukses
            return response()->json([
                'status' => 200,
                'message' => 'Data Orderan Anda Berhasil Di Kirim',
            ]);

            // return redirect()->back();
        }
    }

    public function status_orderan($no_meja)
    {
        $tables = \App\Models\Table::groupBy('no_meja')->orderBy('id', 'DESC')->where('no_meja', $no_meja)->first();
        $detailTables = \App\Models\Table::orderBy('id', 'DESC')->where('no_meja', $no_meja)->get();
        $orders = \App\Models\Order::orderBy('id', 'DESC')
            // ->groupBy('status')
            ->get();
        return view('frontend.order.status-orderan', compact('tables', 'detailTables', 'orders'));
    }

    public function fetch_orderan(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->get('filter_by_status_orderan'))) {
                $order = \App\Models\Order::orderBy('id', 'DESC')->where('status', $request->get('filter_by_status_orderan'))->with('foods')->with('tables')->get();
            } else {
                $order = \App\Models\Order::orderBy('id', 'DESC')->with('foods')->with('tables')->get();
            }
            return datatables()
                ->of($order)
                ->addIndexColumn()
                ->addColumn('nama_pengorder', function ($row) {
                    return '
                                ' .
                        $row->name .
                        '
                            ';
                })
                ->addColumn('no_meja', function ($row) {
                    return '
                                <span class="badge badge-warning">
                                    ' .
                        $row->tables[0]->no_meja .
                        '
                                </span>
                            ';
                })
                ->addColumn('status', function ($row) {
                    return '
                                <span class="badge badge-info">
                                    Sedang Di Proses
                                </span>
                            ';
                })
                ->addColumn('action', function ($row) {
                    return '
                            <div class="btn-group">
                                <a  href="http://localhost/selakopi-exp/public/detail-orderan-pelanggan/' .
                        $row['name'] .
                        '" class="btn-sm btn btn-success">
                                    <i class="far fa-eye"></i>
                                    Struk Pesanan
                                </a>
                            </div>
                            ';
                })
                ->rawColumns(['nama_pengorder', 'no_meja', 'status', 'action'])
                ->make(true);
        }
    }
}
