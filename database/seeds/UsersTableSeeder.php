<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Nomada',
            'email' => 'nomad@gmail.com',
            'password' => bcrypt('nomada123'),
        ]);
        DB::table('users')->insert([
            'name' => 'mohsin',
            'email' => 'mohsin@gmail.com',
            'password' => bcrypt('mohsin'),
        ]);
    }
}
