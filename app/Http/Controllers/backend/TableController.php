<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    public function index()
    {
        return view('backend.table.index');
    }

    public function fetch_meja_makan(Request $request)
    {
        $table = \App\Models\Table::orderBy('id', 'ASC')
            ->get();

        if ($request->ajax()) {
            return datatables()->of($table)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return  '
                                <span class="badge badge-info">
                                ' . $row->status . '
                                </span
                            ';
                })
                ->addColumn('action', function ($row) {
                    return  '
                                <div class="btn-group">
                                    <button id="btnEditMejaMakan" class="btn-sm btn btn-warning" data-id="' . $row['id'] . '">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <button id="btnDeleteMejaMakan" class="btn-sm btn btn-danger" data-id="' . $row['id'] . '">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            ';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_meja'       =>      'required',
            'status'        =>      'required',
        ], [
            'no_meja.required'  =>  'Field No Meja Wajib Di Isi !',
            'status.required'   =>  'Field Status Wajib Di Pilih !',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 400,
                'error'     => $validator->errors()->toArray(),
            ]);
        } else {
            $table          = new \App\Models\Table;
            $table->no_meja = $request->get('no_meja');
            $table->status  = $request->get('status');
            $table->save();

            return response()->json([
                'status'    => 200,
                'message'   => 'Data Meja Makan Berhasil Di Tambahkan',
            ]);

            // return redirect()->route('meja');
        }
    }

    public function edit(Request $request)
    {
        $table = \App\Models\Table::find($request->get('table_id'));
        return response()->json([
            'status'    => 200,
            'table'     => $table,
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_meja'       =>      'required',
            'status'        =>      'required',
        ], [
            'no_meja.required'  =>  'Field No Meja Wajib Di Isi !',
            'status.required'   =>  'Field Status Wajib Di Pilih !',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 400,
                'error'     => $validator->errors()->toArray(),
            ]);
        } else {
            $table          = \App\Models\Table::find($request->get('table_id'));
            $table->no_meja = $request->get('no_meja');
            $table->status  = $request->get('status');
            $table->update();

            return response()->json([
                'status'    => 200,
                'message'   => 'Data Meja Makan Berhasil Di Perbaharui',
            ]);

            // return redirect()->route('meja');
        }
    }

    public function destroy(Request $request)
    {
        $table = \App\Models\Table::find($request->get('table_id'));
        $table->delete();

        return response()->json([
            'status'    => 200,
            'message'   => 'Data Meja Makan Berhasil Di Hapus',
        ]);
    }

    public function ajaxSearch(Request $request)
    {
        $keyword    =   $request->get('q');
        $table      =   \App\Models\Table::where("no_meja", "LIKE", "%$keyword%")
            ->get();

        return $table;
    }
}
