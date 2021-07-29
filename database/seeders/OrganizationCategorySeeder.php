<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['text' => 'Sole Proprietorship'],
            ['text' => 'Partnership'],
            ['text' => 'Corporation'],
            ['text' => 'Limited Liability Company'],
        ];
        DB::table('categories')->insert($categories);
    }
}
