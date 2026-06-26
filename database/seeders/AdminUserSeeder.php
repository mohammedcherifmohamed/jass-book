<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Jass Admin',
            'email' => 'yasmine.jr123@gmail.com',
            'password' => 'password@jass123',
        ]);
    }
}
