<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::truncate();
        Admin::create([
            'name' => "Eslam",
            'email' => "elma3srawiii@gmail.com",
            'password' => bcrypt("123123123"),
            'email_verified_at' => now(),
        ]);
    }
}
