<?php

namespace App\Http\Controllers;

use App\Receta;
use Illuminate\Http\Request;

class LikesController extends Controller
{

    //proteger componente o  el controller  para que cada usuario este autenticado para acceder al update
        public function __construct()
       {
           # code...usar los middleware para la segurida de la auth
           $this->middleware('auth');
       }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $objreceta)
    {

        //Almacena los likes de un usuario a una receta
        //toggle metodo que maneja el evento del click sobre los me gusta $recetasagrupada
        return auth()->user()->meGusta()->toggle($objreceta);
    }


}
