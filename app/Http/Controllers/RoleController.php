<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('idrole')
            ->paginate(10);

        return view('role.index', compact('roles'));
    }

    public function create()
    {
        return view('role.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'idrole' => [
                'required', 'integer', 'unique:v_role,idrole',
            ],
            'nama_role' => [
                'required', 'string', 'max:45',
            ],
        ]);

        Role::create($data);

        return redirect()
            ->route('role.index')
            ->with('success', 'Role berhasil ditambahkan!');
    }

    public function edit(int $id)
    {
        $role = Role::findOrFail($id);
        return view('role.edit', compact('role'));
    }

    public function update(Request $request, int $id)
    {
        $role = Role::findOrFail($id);

        $data = $request->validate([
            'nama_role' => [
                'required', 'string', 'max:45',
            ],
        ]);

        $role->update($data);

        return redirect()
            ->route('role.index')
            ->with('success', 'Role berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()
            ->route('role.index')
            ->with('success', 'Role berhasil dihapus!');
    }
}
