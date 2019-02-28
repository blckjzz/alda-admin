<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class add_new_status_to_status_table extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            'id' => 5,
            'status' => 'Reunião realizada'
        ]);
    }
}
