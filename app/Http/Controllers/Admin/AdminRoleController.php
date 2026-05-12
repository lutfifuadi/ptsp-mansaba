<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminRoleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $users = User::when($search, function ($q, $search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('username', 'like', "%{$search}%")
              ->orWhere('role', 'like', "%{$search}%");
        })->orderBy('name')->paginate(10);

        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'user'  => User::where('role', 'user')->count(),
            'staff'  => User::where('role', 'staff')->count(),
        ];

        return view('content.pages.admin.role.index', compact('users', 'stats'));
    }

    public function create()
    {
        return view('content.pages.admin.role.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role'     => ['required', 'string', Rule::in(['admin', 'staff', 'user'])],
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('admin.role.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('content.pages.admin.role.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'     => ['required', 'string', Rule::in(['admin', 'staff', 'user'])],
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['string', 'min:8']]);
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

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
