<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table('users')->insert(
            [
            'name'=>'sanki',
            'email'=>'sanki@sanki.com',
            'password'=>Hash::make('sanki'),
            'streamName'=>'carapanchini'
            ]);

        DB::table('users')->insert(
            [
            'name'=>'muxi',
            'email'=>'muxi@muxi.com',
            'password'=>Hash::make('muxi'),
            'streamName'=>'muxiguapa'
            ]);

    }
}
