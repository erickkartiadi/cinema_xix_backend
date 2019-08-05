<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin1',
            'role' => 'admin',
            'username' => 'admin1',
            'password' => bcrypt('admin1'),
        ]);
        DB::table('users')->insert([
            'name' => 'admin2',
            'role' => 'admin',
            'username' => 'admin2',
            'password' => bcrypt('admin2'),
        ]);
        DB::table('users')->insert([
            'name' => 'user1',
            'role' => 'user',
            'username' => 'user1',
            'password' => bcrypt('user1'),
        ]);
    }
}
