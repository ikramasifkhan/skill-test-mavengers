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
            [
                'name' => 'Sports',
                'slug' => 'sports',
            ],
            [
                'name' => 'Politics',
                'slug' => 'politics',
            ],
            [
                'name' => 'Entertainment',
                'slug' => 'entertainment',
            ],
            [
                'name' => 'National',
                'slug' => 'national',
            ],
            [
                'name' => 'International',
                'slug' => 'international',
            ],
        ]);
    }
}
