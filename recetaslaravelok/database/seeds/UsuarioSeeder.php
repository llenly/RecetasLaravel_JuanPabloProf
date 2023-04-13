<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds. para usuarios
     *
     * @return void
     */
    public function run()
    {
       //variable para generar nuevos usuarios y perfiles en base a ese usuario creado
         $user = User:: create([
            'name' =>'ejemplo',
            'email' =>'ejemplo@gmail.com',
            'password' =>Hash::make('12345678'),
            'url' =>'http://google.com',
         ]);


        //crear un perfil en base al usuario creado
         // $user->perfil()->create();


 //variable para generar nuevos usuarios y perfiles en base a ese usuario creado segundo usrios creado
        /*   $user2 = User:: create([
            'name' =>'ejemplo2',
            'email' =>'ejemplo2@gmail.com',
            'password' =>Hash::make('12345678'),
            'url' =>'http://google.com',
         ]); */


        //crear  perfil en base al usuario creado desde el seed, al crear el evento en el modelo user para que se guarde un perfil cuando se crea un usuario esto no hace falta 
        //  $user->perfil()->create();






        //Creas las tablas para cada usuario con los campos que quieres, pero obligatorio tener los mismo campos de la tabla usuario o a la que hace referencia
       /*  DB::table('users')->insert ([
            'name' =>'ejemplo',
            'email' =>'ejemplo@gmail.com',
            'password' =>Hash::make('12345678'),
            'url' =>'http://google.com',
            'created_at'=> date('Y-m-d H:i:s '),//formato de fecha
            'updated_at'=> date('Y-m-d H:i:s '),//formato de fecha

        ]); */
        /* DB::table('users')->insert ([
            'name' =>'ejemplo2',
            'email' =>'ejemplo2@gmail.com',
            'password' =>Hash::make('12345678'),
            'url' =>'http://google.com',
            'created_at'=> date('Y-m-d H:i:s '),//formato de fecha
            'updated_at'=> date('Y-m-d H:i:s '),//formato de fecha

        ]); */
    }
}

