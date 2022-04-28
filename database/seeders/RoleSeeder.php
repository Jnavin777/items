<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'Super Admin',
            'quard_name' => 'web',
            'slug' => 'super_admin'
        ], [
            'id' => 2,
            'name' => 'Member',
            'quard_name' => 'web',
            'slug' => 'member'
        ], [
            'id' => 3,
            'name' => 'Watcher',
            'quard_name' => 'web',
            'slug' => 'watcher'
        ], [
            'id' => 4,
            'name' => 'Client',
            'quard_name' => 'web',
            'slug' => 'client'
        ]);
    }
}
