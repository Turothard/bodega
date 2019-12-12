<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        User::Create([
            'name' => 'Marcos Aballay',
            'email' => 'marcos@servicios.zeal.cl',
            'password' => bcrypt('12345678'),
            'department'=>'ADMIN'
        ]);
        User::Create([
            'name' => 'Jonathan Caceres',
            'email' => 'jcaceres@servicios.zeal.cl',
            'password' => bcrypt('12345678'),
            'department'=>'ADMIN'
        ]);
        User::Create([
            'name' => 'Mauricio Rivera',
            'email' => 'mrivera@servicios.zeal.cl',
            'password' => bcrypt('12345678'),
            'department'=>'ADMIN'
        ]);
        User::Create([
            'name' => 'Caparaz Zeal',
            'email' => 'capataz@servicios.zeal.cl',
            'password' => bcrypt('12345678'),
            'department'=>'TRABAJADORES'
        ]);
        User::Create([
            'name' => 'Supervisor Zeal',
            'email' => 'supervisor@servicios.zeal.cl',
            'password' => bcrypt('12345678'),
            'department'=>'SUPERVISORES'
        ]);
        User::Create([
            'name' => 'Bodega Zeal',
            'email' => 'bodega@servicios.zeal.cl',
            'password' => bcrypt('12345678'),
            'department'=>'BODEGA'
        ]);
    }
}
