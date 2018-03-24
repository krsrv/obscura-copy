<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for($i=0; $i<20; $i++){
            DB::table('levels')->insert([
                'id' => $i,
                'levelName' => 'level'.strval($i)
            ]);
            DB::table('hints')->insert([
                'id' => $i,
                'hints' => 'Uh-oh',
                'level' => 'level'.strval($i)
            ]);
            DB::table('answers')->insert([
                'id' => $i,
                'answer1' => strval($i)
            ]);
        }
        // $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}
