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
            'name' => 'CARLOS GRANADA',
            'rut' => '09930341-7',
            'email' => 'stransito@servicios.zeal.cl',
            'password' => bcrypt('0341sup20'),
            'department'=>'SUPERVISORES'
        ]);
User::Create([
            'name' => 'CARLOS QUINTANA',
            'rut' => '15101323-6',
            'email' => 'saforo@servicios.zeal.cl',
            'password' => bcrypt('1323sup20'),
            'department'=>'SUPERVISORES'
        ]);
User::Create([
            'name' => 'JAIME RAMIREZ',
            'rut' => '16106109-3',
            'email' => 'jramirez@servicios.zeal.cl',
            'password' => bcrypt('6109cap20'),
            'department'=>'TRABAJADORES'
        ]);
User::Create([
            'name' => 'ALAN ROJAS',
            'rut' => '19011857-6',
            'email' => 'arojas@servicios.zeal.cl',
            'password' => bcrypt('1857cap20'),
            'department'=>'TRABAJADORES'
        ]);
User::Create([
            'name' => 'GABRIEL ARREDONDO',
            'rut' => '15078647-9',
            'email' => 'garredondo@servicios.zeal.cl',
            'password' => bcrypt('8647cap20'),
            'department'=>'TRABAJADORES'
        ]);
User::Create([
            'name' => 'MARCELO URRA',
            'rut' => '13877908-4',
            'email' => 'murra@servicios.zeal.cl',
            'password' => bcrypt('7908cap20'),
            'department'=>'TRABAJADORES'
        ]);
User::Create([
            'name' => 'LUIS VILLAR',
            'rut' => '17475558-2',
            'email' => 'lvillar@servicios.zeal.cl',
            'password' => bcrypt('5558cap20'),
            'department'=>'TRABAJADORES'
        ]);
User::Create([
            'name' => 'KEVIN FARÍAS',
            'rut' => '18272185-9',
            'email' => 'priesgos@servicios.zeal.cl',
            'password' => bcrypt('prevencion.2020'),
            'department'=>'ADMIN'
        ]);
User::Create([
            'name' => 'MAURICIO RIVERA',
            'rut' => '10943719-0',
            'email' => 'mrivera@servicios.zeal.cl',
            'password' => bcrypt('zservof307'),
            'department'=>'ADMIN'
        ]);
User::Create([
            'name' => 'JONATHAN CACERES',
            'rut' => '17560348-4',
            'email' => 'jcaceres@servicios.zeal.cl',
            'password' => bcrypt('zservof307'),
            'department'=>'ADMIN'
        ]);
User::Create([
            'name' => 'JOSE CONAPIAO',
            'rut' => '16106197-2',
            'email' => 'bodega@servicios.zeal.cl',
            'password' => bcrypt('bodega.2020'),
            'department'=>'BODEGA'
        ]);
User::Create([
            'name' => 'MARCOS ABALLAY',
            'rut' => '172732011-1',
            'email' => 'admin@servicios.zeal.cl',
            'password' => bcrypt('admin.2020'),
            'department'=>'ADMIN'
        ]);

    }
}
