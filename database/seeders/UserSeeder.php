<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@gmail.com';
        $admin->country_id = 77;
        $admin->password = Hash::make('password');
        $admin->email_verified_at = now();
        $admin->save();
        $admin->assignRole('admin');
    }
}
