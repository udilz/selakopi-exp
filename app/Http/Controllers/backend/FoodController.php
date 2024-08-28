<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    public function index()
    {
        $food       = \App\Models\Food::orderBy('id', 'DESC')
            ->groupBy('category_id')
            ->get();
        $categories = \App\Models\Category::all();

        return view('backend.food.index', compact('food', 'categories'));
    }

    public function fetch_makanan(Request $request)
    {
        $food = \App\Models\Food::orderBy('id', 'DESC')
            ->get();

        if ($request->ajax()) {
            if (!empty($request->get('foodByCategory'))) {
                $food = \App\Models\Food::where('category_id', $request->get('foodByCategory'))
                    ->get();
            } else {
                $food = \App\Models\Food::get();
            }
            return datatables()->of($food)
                ->addIndexColumn()
                ->addColumn('photo', function ($row) {
                    return  '
                                <img src="storage/makanan-dan-minuman/' . $row->photo . '" width="80px" />
                            ';
                })
                ->addColumn('harga_beli', function ($row) {
                    return  '
                                ' . formatRupiah($row->harga_beli) . '
                            ';
                })
                ->addColumn('kategori', function ($row) {
                    return  '
                            <span class="badge badge-pill badge-success">
                            ' . $row->categories->name . '
                            </span>
                        ';
                })
                ->addColumn('action', function ($row) {
                    return  '
                            <div class="btn-group">
                                <button id="btnEditMakanan" class="btn-sm btn btn-warning" data-id="' . $row['id'] . '">
                                    <i class="far fa-edit"></i>
                                </button>
                                <button id="btnDeleteMakanan" class="btn-sm btn btn-danger" data-id="' . $row['id'] . '">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        ';
                })
                ->rawColumns(['photo', 'harga_beli', 'kategori',  'action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          =>  'required',
            'photo'         =>  'max:2048',
            'harga_beli'    =>  'required',
            'minimal_stock' =>  'required',
            'status'        =>  'required',
        ], [
            'name.required'         =>  'Field Nama Makanan / Minuman Wajib Di Isi !',
            'photo.max'             => 'Field Foto Makanan / Minuman Maksimal Ukuran 2Mb !',
            'harga_beli.required'   => 'Field Harga Beli Makanan / Minuman Wajib Di Isi !',
            'minimal_stock.required'         =>  'Field Stock Makanan / Minuman Wajib Di Isi !',
            'status.required'       => 'Field Status Makanan / Minuman Wajib Di Pilih !',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  400,
                'error'     =>  $validator->errors()->toArray(),
            ]);
        } else {
            $file_path_makanan = 'storage/makanan-dan-minuman/';
            $file_makanan      = $request->file('photo');
            $filename_makanan  = $file_makanan->getClientOriginalName();
            $request->file('photo')->move($file_path_makanan, $filename_makanan);

            $food               = new \App\Models\Food;
            $food->name         = $request->get('name');
            $food->photo        = $filename_makanan;
            $food->harga_beli   = $request->get('harga_beli');
            $food->minimal_stock = $request->get('minimal_stock');
            $food->slug         = \Str::slug($request->get('name'));
            $food->status       = $request->get('status');
            $food->category_id  = $request->get('category_id');
            $food->save();

            return response()->json([
                'status'    => 200,
                'message'   => 'Data Makanan / Minuman Berhasil Di Tambahkan',
            ]);
            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
        $food = \App\Models\Food::find($request->get('food_id'));
        return response()->json([
            'status'    => 200,
            'food'      => $food,
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          =>  'required',
            'photo'         =>  'max:2048',
            'harga_beli'    =>  'required',
            'minimal_stock' =>  'required',
            'status'        =>  'required',
        ], [
            'name.required'         =>  'Field Nama Makanan / Minuman Wajib Di Isi !',
            'photo.max'             => 'Field Foto Makanan / Minuman Maksimal Ukuran 2Mb !',
            'harga_beli.required'   => 'Field Harga Beli Makanan / Minuman Wajib Di Isi !',
            'minimal_stock.required'         =>  'Field Minimal Stock Makanan / Minuman Wajib Di Isi !',
            'status.required'       => 'Field Status Makanan / Minuman Wajib Di Pilih !',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 400,
                'error'     => $validator->errors()->toArray(),
            ]);
        } else {
            $food = \App\Models\Food::find($request->get('food_id'));

            if ($request->hasFile('photo_edit')) {
                $file_old_photo = 'makanan-dan-minuman/' . $food->photo;
                //file exists
                if ($food->photo != null && Storage::disk('public')->exists($file_old_photo)) {
                    Storage::disk('public')->delete($file_old_photo);
                }
                // save new photo;
                $file_path_photo = 'storage/makanan-dan-minuman/';
                $file_photo      = $request->file('photo_edit');
                $filename_photo  = $file_photo->getClientOriginalName();
                $request->file('photo_edit')->move($file_path_photo, $filename_photo);
                $save_photo      = $filename_photo;
            } else {
                $save_photo = $request->get('tmp_photo');
            }

            //save to db foods;
            $food->name         = $request->get('name');
            $food->photo        = $save_photo;
            $food->harga_beli   = $request->get('harga_beli');
            $food->minimal_stock = $request->get('minimal_stock');
            $food->slug         = \Str::slug($request->get('name'));
            $food->status       = $request->get('status');
            $food->category_id  = $request->get('category_id');
            $food->update();

            return response()->json([
                'status'    => 200,
                'message'   => 'Data Makanan / Minuman Berhasil Di Perbaharui',
            ]);

            // return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        $food           = \App\Models\Food::find($request->get('food_id'));
        //delete img
        $file_old_photo = 'makanan-dan-minuman/' . $food->photo;
        if ($food->photo != null && Storage::disk('public')->exists($file_old_photo)) {
            Storage::disk('public')->delete($file_old_photo);
        }
        $food->delete();

        return response()->json([
            'status'    => 200,
            'message'   => 'Data Makanan Berhasil Di Hapus',
        ]);
    }

    public function ajaxSearch(Request $request)
    {
        $keyword    =   $request->get('q');
        $food       =   \App\Models\Food::where("name", "LIKE", "%$keyword%")
            ->get();

        return $food;
    }

    public function kategori_makanan($slug)
    {
        $kategoriMakanan = \App\Models\Category::where('slug', $slug)
            ->first();
        $idMakanan       = $kategoriMakanan->id;
        $categories      = \App\Models\Category::all();
        $nameMakanan     = $kategoriMakanan->name;

        $foods              = \App\Models\Food::orderBy('id', 'DESC')
            ->where('category_id', $idMakanan)
            ->paginate(10);

        return view('backend.food.foodByCategory', compact('foods', 'categories', 'nameMakanan'));
    }
}
