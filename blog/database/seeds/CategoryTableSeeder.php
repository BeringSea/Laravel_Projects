<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->name = 'Tech';
        $category->save();

        $category = new Category();
        $category->name = 'Sports';
        $category->save();

        $category = new Category();
        $category->name = 'Food';
        $category->save();
    }
}
