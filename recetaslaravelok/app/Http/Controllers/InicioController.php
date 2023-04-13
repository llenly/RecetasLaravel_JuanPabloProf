<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InicioController extends Controller
{

    //metodo para retornar la vista de la pagina de inicio
    public function index(){

        //con el has (es un buscador) haces una busqueda en base a la elacion que tengas echas y a la tabla que quieras buscar
        //MOSTAR LAS RECETAS POR CANTIDAD DE VOTOS O LIKES, like ya tienes echa esa relacion anteriormente en el like y el get te trae las recetas votadas
       //  $recetasvotadas = Receta::has('likes', '>', 0)->get(); esto es mas estatico

        // saber cuantos likes tiene cada receta, crea una columna likecount nueva temporal en los resulatados,
        // este es mas dinamico, hay que pasarle esta var o instancia a la vista con elcompact
        $recetasvotadas = Receta::withCount('likes')->orderBy('likes_count', 'desc')->take(3)->get();
        // return $recetasvotadas;

    //OBTENER LAS RCETAS MAS NUEVAS DEL MODELO RECETAS Y MOSTRARLA EN LA PAGNA DE INICIO CON EL METODO GET ,
    // DUDA ASC ES ASECENDETE POR DEFAULT, E IMPORTAR EL MODELO RECETAS
    //LATEST, SACA LOS ULTIMAS MAS NUEVAS DE LA CONULTA Y OLDEST LOS MAS VIEJOS , ORDERBY('created_at', 'ASC'), LIMIT Y TAKE PARA LIMITAR EL RESULTADO
    //HAY QUE PASAR LA CONSULTA VIA COMPACT, y devuelve un array en la var nuevass

        $recetasnueva = Receta::latest()->take(3)->get();
    // return $recetasnuevas;

    //OBTENER LAS RECETAS POR CATEGORIAS, PRIMERO OBTENER TODAS LAS CATEGORIAS Y DE AHI ITERAR Y AGRUPAR SEGUN LA CATEGOIRA
    //obtener todas las categorias del modelo categorias recetas, importar la clase de este modelo o del que estes usando siempre
       $categorias = CategoriaReceta::all();
     // return $categorias;

    //AGRUPAR LAS RECETAS POR CATEGORIAS , y guardarlas en array , luego iterar en un array de dos dimesiones o sea dos array una para categoria y otro para las recetas
     $recetasagrupada = []; //  objreceta pasa a ser esta instancia recestasagrupada , y al iterar en recetaagrupa guarda la coleccion

       foreach($categorias as $categoria){
           // array dentro de otro array , dos dimesnsiones devuelve todas las recetas agrupadas por id o por el nombre , dentro de cada categoria agrupado por id y take para que traiga 2 de cada categoria
           //usar el helper slug para quitar espacios y duda con url, hay que importar el slug de support, el slug en la vista se convierte en key para iterar el array con el foreach
           $recetasagrupada [ Str::slug($categoria->nombre) ] [] = Receta::where('categoria_id', $categoria->id)->take(3)->get();

           //$recetaagrupada [ $categoria->id] [] = Receta::where('categoria_id', $categoria->id)->get();
       }
 //return $recetasagrupada;





     //$mexicana = Receta::where('categoria_id')->get(); CONSULTA PARA TRAER LA CATEGORIA SEGUN EL ID DE LA DB


      //return "desde inicio";

     //DEVUELVE LA VISTA
       return view('inicio.index',compact('recetasnueva', 'recetasagrupada','recetasvotadas'));
    }

}
