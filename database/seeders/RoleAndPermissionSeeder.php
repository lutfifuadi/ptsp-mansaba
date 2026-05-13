<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Hapus role yang tidak digunakan lagi
        Role::whereIn('name', ['mitra', 'staff', 'user'])->delete();

        $allPermissions = [
            'lihat-siswa', 'tambah-siswa', 'edit-siswa', 'hapus-siswa', 'impor-siswa',
            'lihat-guru', 'tambah-guru', 'edit-guru', 'hapus-guru', 'impor-guru',
            'lihat-petugas', 'tambah-petugas', 'edit-petugas', 'hapus-petugas',
            'lihat-ptsp', 'kelola-ptsp', 'export-ptsp',
            'lihat-buku-tamu', 'hapus-buku-tamu', 'export-buku-tamu', 'reset-buku-tamu',
            'lihat-user', 'tambah-user', 'edit-user', 'hapus-user',
            'kelola-role',
            'lihat-pengaturan', 'edit-pengaturan',
        ];

        foreach ($allPermissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $roles = ['admin', 'operator'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        $admin = Role::findByName('admin');
        $admin->syncPermissions($allPermissions);

        $operator = Role::findByName('operator');
        $operator->syncPermissions([
            'lihat-siswa', 'tambah-siswa', 'edit-siswa', 'hapus-siswa', 'impor-siswa',
            'lihat-guru', 'tambah-guru', 'edit-guru', 'hapus-guru', 'impor-guru',
            'lihat-petugas', 'tambah-petugas', 'edit-petugas', 'hapus-petugas',
            'lihat-ptsp', 'kelola-ptsp', 'export-ptsp',
            'lihat-buku-tamu', 'hapus-buku-tamu', 'export-buku-tamu', 'reset-buku-tamu',
        ]);


        User::all()->each(function ($user) {
            if ($user->role) {
                $user->assignRole($user->role);
            }
        });
    }
}
