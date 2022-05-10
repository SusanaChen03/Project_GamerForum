<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
            'name'=>'sanki',
            'email'=>'sanki@sanki.com',
            'password'=>'sanki',
            'streamName'=>'carapanchini'
            ]);

        DB::table('users')->insert(
            [
            'name'=>'muxi',
            'email'=>'muxi@muxi.com',
            'password'=>'muxi',
            'streamName'=>'muxiguapa'
            ]);

    }
}
