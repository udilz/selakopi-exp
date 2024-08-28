<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('backend.user.index');
    }

    public function fetchUsers(Request $request)
    {
        $users = User::orderBy('id', 'DESC')->get();

        if ($request->ajax())
        {
            return datatables()->of($users)
                ->addIndexColumn()
                ->addColumn('roles', function ($row) {
                    return  '
                                <span class="badge badge-info">
                                ' . $row->roles . '
                                </span
                            ';
                })
                ->addColumn('action', function ($row) {
                    return  '
                            <div class="btn-group">
                                <button id="btnEditUsers" class="btn-sm btn btn-warning" data-id="' . $row['id'] . '">
                                    <i class="far fa-edit"></i>
                                </button>
                                <button id="btnDeleteUsers" class="btn-sm btn btn-danger" data-id="' . $row['id'] . '">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                            ';
                })
                ->rawColumns(['roles','action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'email|required',
            'roles'     => 'required',
            'password'  => 'required'
        ], [
            'name.required'     => 'Field Nama Wajib Di Isi !',
            'email.required'    => 'Field Email Wajib Di Isi !',
            'email.email'       => 'Field Email Harus Berformat Email !',
            'roles.required'    => 'Field Roles Wajib Di Isi !',
            'password.required' => 'Field Password Wajib Di Isi !'
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'status'     => 400,
                'error'      => $validator->errors()->toArray()
            ]);
        }
        else
        {
            $users              = new User;
            $users->name        = $request->get('name');
            $users->email       = $request->get('email');
            $users->roles       = $request->get('roles');
            $users->password    = bcrypt($request->get('password'));
            $users->save();

            return response()->json([
                'status'    => 200,
                'message'   => 'Data Pengguna Berhasil Di Simpan !',
            ]);
        }


    }

    public function edit(Request $request)
    {
        $users = User::find($request->get('users_id'));
        return response()->json([
            'status'    => 200,
            'users'     => $users,
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'email|required',
            'roles'     => 'required',
            'password'  => 'required'
        ], [
            'name.required'     => 'Field Nama Wajib Di Isi !',
            'email.required'    => 'Field Email Wajib Di Isi !',
            'email.email'       => 'Field Email Harus Berformat Email !',
            'roles.required'    => 'Field Roles Wajib Di Isi !',
            'password.required' => 'Field Password Wajib Di Isi !'
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'status'    => 400,
                'error'     => $validator->errors()->toArray(),
            ]);
        }
        else
        {
            $users              = User::find($request->get('users_id'));
            $users->name        = $request->get('name');
            $users->email       = $request->get('email');
            $users->roles       = $request->get('roles');
            $users->password    = bcrypt($request->get('password'));
            $users->update();

            return response()->json([
                'status'        => 200,
                'message'       => 'Data User Berhasil Di Perbaharui !',
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $users = User::find($request->get('users_id'));
        $users->delete();

        return response()->json([
            'status'    => 200,
            'message'   => 'Data Pengguna Berhasil Di Hapus !',
        ]);
    }
}
