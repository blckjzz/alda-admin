<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class createConselheiroRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([

            'name' => 'conselheiro',
            'display_name' => 'Conselheiro'
        ]);
    }
}
