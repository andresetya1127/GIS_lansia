<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $roles = Role::class;
    protected $users = User::class;

    public  function index()
    {
        $title = __('delete users');
        $text = __('confirm message', ['action' => 'Hapus']);
        confirmDelete($title, $text);

        return view('pages.admin.user.index');
    }

    public  function create()
    {
        $roles = $this->roles::get();

        return view('pages.admin.user.create', ['roles' => $roles]);
    }

    public function edit($id)
    {
        $roles = $this->roles::get();
        $user = $this->users::find($id);

        return view('pages.admin.user.edit', ['roles' => $roles, 'user' => $user]);
    }

    public  function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required',  'min:8'],
            'password_confirmation' => ['required', 'min:8', 'same:password'],
            'roles' => ['required', 'array', 'min:1', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $user->assignRole($request->roles);

        toast('Data berhasil disimpan', 'success');
        return redirect()->route('users');
    }


    public  function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($id)],
            'password' => ['min:8', 'nullable'],
            'password_confirmation' => ['min:8', 'same:password', 'nullable'],
            'roles' => ['required', 'array', 'min:1', 'exists:roles,name'],
        ]);

        $user = $this->users::find($id)
            ->syncRoles($request->roles)
            ->update($request->password ? $request->all() : $request->only(['name', 'email']));

        toast('Data berhasil disimpan', 'success');
        return redirect()->route('users');
    }
}
