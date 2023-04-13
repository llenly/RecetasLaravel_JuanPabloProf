<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{

     //Campos que se agregaras en las tablas , se va a inyectar solo lo que definas aqui, son los mismos campos que pones en la tabla recetas
    protected $fillable = [
        'titulo', 'preparacion', 'ingredientes','imagen','categoria_id'
    ];

     //obtener la categoria de la receta via llave forena , para eso primero creas el modelo que es categoriareceta y trabjas sobre el y haces  la relacion de las tabla categoria con la de receta
     // hay una relacion inversa una receta tiene una categoria --DUDA
     //este metodo categoria es el que llamas en el indexblade para mostar las categorias de cada receta
     //para almecenar los datos de las recetas con modelo te vas al controller y trabajas ahi
     public function categoria()
     {
         return $this->belongsTo(CategoriaReceta::class);
     }

     //OBTENER LA INFORMACION DEL USUARIO VIA FOREING KEY, creando una relacion de la tabla receta con la de usuario para sacr el id de la categoria
       public function relacionautor()
       {
           return $this->belongsTo(User::class, 'user_id'); //el segundo valor user_id es el foreing key de esta tabla usuario, hay que especificar en que columna de la tabla se guarda la relacion
       }

    //relacion para los likes que recibe una receta
    //relacon de muechos a muchos de los usuarios a las recetas, decir en que tabla pivote  hace la relacion o se guarda la informacion
    //crear la tabla pivote y hacer la migration luego hacer la relacion entre las dos tablas
    //hacer la relacion tambien en user para los likes que le da a las recetas,'recetas_id','user_id' quizas pasarlo como paramerp
       public function likes(){
           return $this->belongsToMany(User::class, 'likes_receta');
       }

}
