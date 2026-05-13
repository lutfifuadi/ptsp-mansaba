<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Spatie\Permission\Models\Role;

class AdminRoleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $users = User::when($search, function ($q, $search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('username', 'like', "%{$search}%")
              ->orWhereHas('roles', function($rq) use ($search) {
                  $rq->where('name', 'like', "%{$search}%");
              });
        })->orderBy('name')->paginate(10);

        $roles = Role::all();
        $stats = [
            'total' => User::count(),
        ];
        
        foreach ($roles as $role) {
            $stats[$role->name] = User::role($role->name)->count();
        }

        return view('content.pages.admin.role.index', compact('users', 'stats', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('content.pages.admin.role.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $roles = Role::pluck('name')->toArray();
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role'     => ['required', 'string', Rule::in($roles)],
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $user->assignRole($data['role']);

        return redirect()->route('admin.role.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('content.pages.admin.role.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $roles = Role::pluck('name')->toArray();
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'     => ['required', 'string', Rule::in($roles)],
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['string', 'min:8']]);
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);
        $user->syncRoles($data['role']);

        return redirect()->route('admin.role.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.role.index')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.role.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
