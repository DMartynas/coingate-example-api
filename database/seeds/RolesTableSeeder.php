<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('roles')->insert([
            'name' => 'Vartotojas',
            'slug' => 'Vartotojas',
        ]);

        DB::table('roles')->insert([
            'name' => 'Vadybininkas',
            'slug' => 'Vadybininkas',
        ]);

        DB::table('roles')->insert([
            'name' => 'Admin',
            'slug' => 'Admin',
        ]);
    }
}
