<?php

use Illuminate\Database\Seeder;

class UsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => '3',
            'name' => 'Admin',
            'email' => 'mart1@ynas.com',
            'password' => bcrypt('stud'),

        ]);
        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Vadybininkas',
            'email' => 'mart2@ynas.com',
            'password' => bcrypt('stud'),

        ]);
    }
}
