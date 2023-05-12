<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Create admin user
        DB::table('users')->insert([
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => Hash::make('password'),
            'active' => true,
            'admin' => true,
        ]);
    }
}
