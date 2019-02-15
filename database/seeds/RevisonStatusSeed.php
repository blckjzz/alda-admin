<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RevisonStatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('revision_status')->insert([
            'id' => 1,
            'status' => 'Em Análise',
        ]);

        DB::table('revision_status')->insert([
            'id' => 2,
            'status' => 'Aprovado',
        ]);

        echo 'Status revision: seeded';
    }
}
