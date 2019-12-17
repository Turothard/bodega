<?php

use Illuminate\Database\Seeder;
use App\Posicione;
class PosicionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Posicione::class,300)->create();
    }
}
