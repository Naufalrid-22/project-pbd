<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('v_user_list')
            ->orderBy('iduser')
            ->paginate(10);

        return view('user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('idrole')->get();
        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'iduser' => [
                'required', 'integer', 'unique:v_user,iduser',
            ],
            'username' => [
                'required', 'string', 'max:50', 'unique:v_user,username',
            ],
            'password' => [
                'required', 'string', 'min:8',
            ],
            'idrole' => [
                'required', 'integer', 'exists:v_role,idrole'
            ],
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('idrole')->get();
        return view('user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('v_user', 'username')->ignore($id, 'iduser'),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
            ],
            'idrole' => [
                'required',
                'integer',
                'exists:v_role,idrole',
            ],
        ]);

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->username = $data['username'];
        $user->idrole = $data['idrole'];
        $user->save();

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
