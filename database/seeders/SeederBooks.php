<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class SeederBooks extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('table_boos')->insert([
            'name'=>'hieu',
            'email'=>'vlkh00volam13@gmail.com',
        ]);
    }
}
