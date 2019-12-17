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
            'rut' => '17273201-1',
            'email' => 'marcos@servicios.zeal.cl',
            'password' => bcrypt('12345678'),
            'department'=>'ADMIN'
        ]);
        User::Create([
            'name' => 'Jonathan Caceres',
            'rut' => '17560348-4',
            'email' => 'jcaceres@servicios.zeal.cl',
            'password' => bcrypt('12345678'),
            'department'=>'ADMIN'
        ]);
        User::Create([
            'name' => 'Mauricio Rivera',
            'rut' => '10943719-0',
            'email' => 'mrivera@servicios.zeal.cl',
            'password' => bcrypt('12345678'),
            'department'=>'ADMIN'
        ]);
        User::Create([
            'name' => 'Caparaz Zeal',
            'rut' => '15078647-9',
            'email' => 'capataz@servicios.zeal.cl',
            'password' => bcrypt('12345678'),
            'department'=>'TRABAJADORES'
        ]);
        User::Create([
            'name' => 'Supervisor Zeal',
            'rut' => '15101323-6',
            'email' => 'supervisor@servicios.zeal.cl',
            'password' => bcrypt('12345678'),
            'department'=>'SUPERVISORES'
        ]);
        User::Create([
            'name' => 'Bodega Zeal',
            'rut' => '13877058-3',
            'email' => 'bodega@servicios.zeal.cl',
            'password' => bcrypt('12345678'),
            'department'=>'BODEGA'
        ]);
    }
}
