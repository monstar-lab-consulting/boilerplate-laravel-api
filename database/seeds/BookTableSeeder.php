<?php

use Illuminate\Database\Seeder;
use Modules\ElasticSearch\Models\Book as ModelsBook;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return factory(ModelsBook::class, 50)->create();
    }
}
