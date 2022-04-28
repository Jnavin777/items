<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Joe Doy',
            'email' => 'admin@admin.com',
            'password' => Hash::make('223311'),
            'lockout_time' => 10,
        ], [
            'id' => 2,
            'name' => 'The Best Client',
            'email' => 'client@mail.ru',
            'password' => Hash::make('client'),
            'lockout_time' => 10
        ]);
    }
}
