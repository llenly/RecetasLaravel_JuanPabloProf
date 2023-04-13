<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    //trabajar con el metodo show, que es el que meustra la vista $CategoriaRecetaestoesta clase viene del modelo
    public function show( CategoriaReceta $CategoriaReceta){
       // return $CategoriaReceta;
       //haces la consulta a la db para que traiga todas las recetas se usa la instancia  $recetasagrupada  ya creada en iniciocontroller que guarda todas la recetas agrupadas por cada categoria
       //ESTE modelo y controller trabajan con las instancias o clases creadas en el iniciocotroller
       $recetasagrupada = Receta::where('categoria_id', $CategoriaReceta->id)->paginate(3);
      // return  $recetaporcateg;
       //retornar una vista que hay que crear,le pasas la variable creada en un compact a la vista
       return view('categorias.show', compact( 'recetasagrupada', 'CategoriaReceta'));

    }
}
