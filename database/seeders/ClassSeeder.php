<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {
        DB::table('classes')->delete();
        DB::table('classes')->insert([
            'id' => 1,
            'name' => 'class44',
            'niveau' => 0,
            
        ]);
    }
}
