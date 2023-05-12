<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Alpina company
        DB::table('Companies')->insert([
            'nit' => random_int(1000000000,9999999999),
            'name' => 'Alpina',
            'active' => true,
            'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/Alpina_S.A._logo.svg/2560px-Alpina_S.A._logo.svg.png',
        ]);
    }
}
