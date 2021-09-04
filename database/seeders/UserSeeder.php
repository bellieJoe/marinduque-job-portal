<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'email' => 'jobportaldummy@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'verification_code' => '000000',
            'verified' => '1',
        ]);
    }
}
