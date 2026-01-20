<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create(
            [
                "name"=> "Super Admin ",
                "email"=> "superadmin@yayasankembangsawit.com",
                "password"=> bcrypt("12121212"),
                "role"  => 'super-admin',
                "is_aktif"=> true,
                "created_at" => now(),
                "updated_at"=> now(),
            ]
        );

    }
}
