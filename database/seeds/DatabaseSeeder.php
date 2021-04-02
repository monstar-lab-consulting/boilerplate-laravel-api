<?php

use Core\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    protected $toTruncate = ['books'];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        foreach ($this->toTruncate as $table) {
            DB::table($table)->truncate();
        }
        $this->call(BookTableSeeder::class);

        Model::reguard();
    }
}
