<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds. esto son tablas para las categorias , cuando quiersponer mas datos de una misma tabla
     * en este caso dtos de los tipos de categorias que hay
     *
     * @return void
     */
    public function run()
    {
        //Creas las tablas para cada tipo de categproria con los campos que quieres , ademas de los mismos cambos que tiene la tabla a la que hace referncia , en este caso el id nos es necesario
        DB::table('categoria_recetas')->insert ([
            'nombre' =>'Comida Italiana',
            'created_at'=> date('Y-m-d H:i:s '),//formato de fecha
            'updated_at'=> date('Y-m-d H:i:s '),//formato de fecha

        ]);
        DB::table('categoria_recetas')->insert ([
            'nombre' =>'Comida Mexicana',
            'created_at'=> date('Y-m-d H:i:s'),//formato de fecha
            'updated_at'=> date('Y-m-d H:i:s'),//formato de fecha

        ]);
        DB::table('categoria_recetas')->insert ([
            'nombre' =>'Comida Japonesa',
            'created_at'=> date('Y-m-d H:i:s '),//formato de fecha
            'updated_at'=> date('Y-m-d H:i:s '),//formato de fecha

        ]);
        DB::table('categoria_recetas')->insert ([
            'nombre' =>'Comida Cubana',
            'created_at'=> date('Y-m-d H:i:s '),//formato de fecha
            'updated_at'=> date('Y-m-d H:i:s '),//formato de fecha

        ]);
        DB::table('categoria_recetas')->insert ([
            'nombre' =>'Comida Venezolana',
            'created_at'=> date('Y-m-d H:i:s '),//formato de fecha
            'updated_at'=> date('Y-m-d H:i:s '),//formato de fecha

        ]);
        DB::table('categoria_recetas')->insert ([
            'nombre' =>'Comida Argentina',
            'created_at'=> date('Y-m-d H:i:s '),//formato de fecha
            'updated_at'=> date('Y-m-d H:i:s '),//formato de fecha

        ]);
        DB::table('categoria_recetas')->insert ([
            'nombre' =>'Postres',
            'created_at'=> date('Y-m-d H:i:s '),//formato de fecha
            'updated_at'=> date('Y-m-d H:i:s '),//formato de fecha

        ]);
        DB::table('categoria_recetas')->insert ([
            'nombre' =>'Cortes de Carnes',
            'created_at'=> date('Y-m-d H:i:s '),//formato de fecha
            'updated_at'=> date('Y-m-d H:i:s '),//formato de fecha

        ]);
        DB::table('categoria_recetas')->insert ([
            'nombre' =>'Ensaladas',
            'created_at'=> date('Y-m-d H:i:s '),//formato de fecha
            'updated_at'=> date('Y-m-d H:i:s '),//formato de fecha

        ]);
        DB::table('categoria_recetas')->insert ([
            'nombre' =>'Desayunos',
            'created_at'=> date('Y-m-d H:i:s '),//formato de fecha
            'updated_at'=> date('Y-m-d H:i:s '),//formato de fecha

        ]);



    }
}
