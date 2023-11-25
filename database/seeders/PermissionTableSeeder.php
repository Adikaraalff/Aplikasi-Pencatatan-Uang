<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'lokasi_Uang-list',
            'lokasi_Uang-create',
            'lokasi_Uang-edit',
            'lokasi_Uang-delete',
            'uang_Keluar-list',
            'uang_Keluar-create',
            'uang_Keluar-edit',
            'uang_Keluar-delete',
            'uang_Masuk-list',
            'uang_Masuk-create',
            'uang_Masuk-edit',
            'uang_Masuk-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete'
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
