<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'name' => 'Category One',
        ]);

        DB::table('categories')->insert([
            'name' => 'Category Two',
        ]);

        DB::table('categories')->insert([
            'name' => 'Category Three',
        ]);
        DB::table('categories')->insert([
            'name' => 'Category Four',
        ]);

        DB::table('categories')->insert([
            'name' => 'Category Five',
        ]);

        DB::table('categories')->insert([
            'name' => 'Category Six',
        ]);
    }
}
