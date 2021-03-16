<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'vendor']);
        Role::create(['name' => 'customer', 'guard_name' => 'web']);
        $user = User::create([
            'name' => 'Vendor',
            'email' => 'vaisujsree@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('vendor');
    }
}
