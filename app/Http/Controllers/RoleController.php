<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function index()
    {
        $title = __('delete role');
        $text = __('confirm message', ['action' => 'Hapus']);
        confirmDelete($title, $text);

        return view('pages.admin.roles.index');
    }

    public function create()
    {
        $permission = Permission::get()->groupBy('group_name');
        return view('pages.admin.roles.create', ['permission' => $permission]);
    }

    public function store(Request $request)
    {
        $permission = Permission::select('name')->get()->toArray();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'guard' => ['required', 'string', 'max:255'],
            'permissions' => ['required', 'array', 'min:1', 'in:' . implode(',', array_column($permission, 'name'))],
        ]);

        if ($validator->fails()) {
            toast('Data gagal disimpan', 'error');
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $request->name,
                'guard' => $request->guard,
            ]);

            $role->givePermissionTo($request->permissions);
            DB::commit();

            toast('Data berhasil disimpan', 'success');

            return redirect()->route('role');
        } catch (\Throwable $th) {
            DB::rollBack();
            toast('Data gagal disimpan', 'error');
            return back()->with('error', $th->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get()->groupBy('group_name');
        return view('pages.admin.roles.edit', ['role' => $role, 'permission' => $permission]);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $id],
            'guard' => ['required', 'string', 'max:255'],
            'permissions' => ['required', 'array', 'min:1'],
        ]);

        if ($validator->fails()) {
            toast('Data gagal disimpan', 'error');
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $role->update([
                'name' => $request->name,
                'guard' => $request->guard,
            ]);

            $role->syncPermissions($request->permissions);
            DB::commit();

            toast('Data berhasil disimpan', 'success');

            return redirect()->route('role');
        } catch (\Throwable $th) {
            DB::rollBack();
            toast('Data gagal disimpan', 'error');
            return back()->with('error', $th->getMessage())->withInput();
        }
    }


    public function delete($id)
    {
        $role = Role::find($id);
        $role->delete();
        toast('Data berhasil dihapus', 'success');
        return redirect()->route('role');
    }
}
