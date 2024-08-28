<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $category = \App\Models\Category::orderBy('id', 'DESC')
            ->get();
        return view('backend.category.index');
    }

    public function fetch_category(Request $request)
    {
        $category = \App\Models\Category::orderBy('id', 'DESC')
            ->get();

        if ($request->ajax()) {
            return datatables()->of($category)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return  '
                                <div class="btn-group">
                                    <button id="btnEditKategori" class="btn-sm btn btn-warning" data-id="' . $row['id'] . '">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <button id="btnDeleteKategori" class="btn-sm btn btn-danger" data-id="' . $row['id'] . '">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            ';
                })
                ->addColumn('photo', function ($row) {
                    return  '
                                <img src="storage/makanan-dan-minuman/' . $row->photo . '" class="img-fluid" width="80px" />
                            ';
                })
                ->addColumn('price', function ($row) {
                    return  '
                                Rp.
                            ';
                })
                ->rawColumns(['photo', 'price', 'action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      =>  'required',
        ], [
            'name.required' => 'Field Nama Kategori Wajib Di Isi !',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  400,
                'error'     =>  $validator->errors()->toArray(),
            ]);
        } else {

            $category = new \App\Models\Category;
            $category->name     = $request->get('name');
            $category->slug     = \Str::slug($request->get('name'), '-');
            $category->save();

            return response()->json([
                'status'    => 200,
                'message'   => 'Data Kategori Berhasil Di Simpan !',
            ]);
        }
    }

    public function edit(Request $request)
    {
        $category = \App\Models\Category::find($request->get('category_id'));
        return response()->json([
            'status'    => 200,
            'category'  => $category,
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      =>  'required',
        ], [
            'name.required' => 'Field Nama Kategori Wajib Di Isi !',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 400,
                'error'     =>  $validator->errors()->toArray(),
            ]);
        } else {
            $category       = \App\Models\Category::find($request->get('category_id'));
            $category->name = $request->get('name');
            $category->slug = \Str::slug($request->get('name'), '-');
            $category->update();

            return response()->json([
                'status'    => 200,
                'message'   => 'Data Kategori Berhasil Di Perbaharui',
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $category = \App\Models\Category::find($request->get('category_id'));
        $category->delete();

        return response()->json([
            'status'    => 200,
            'message'   => 'Kategori Berhasil Di Hapus',
        ]);
    }

    public function ajaxSearch(Request $request)
    {
        $keyword    = $request->get('q');
        $category   = \App\Models\Category::where("name", "LIKE", "%$keyword%")
            ->get();

        return $category;
    }
}
