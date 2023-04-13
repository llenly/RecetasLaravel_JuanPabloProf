<?php

namespace App;

 use Illuminate\Database\Eloquent\Model;

 class Perfil extends Model
 {
    //dato las relaciones se cran en el modelo usuarioo
    //creas la tabla de perfil con los campos que quieras y haces la migracion
    //luego haces la relacion de la tabla usuario a la tabla perfil y si quieres una relacion inversa de perfil a usuario , haces la relacion en el modelo perfil tambien (o sea aqui)
    //RELACION 1:1 DE PERFIL CON USUARIO
   // Perfil::find(1); TRAE LA INFORMACION DEL USUARIO DESDE EL PERFIL
   // eventos de eloquent que se agregan en el modelo de usuario para que se ejecute cuando se crea un usuario
   //hacer un seed para perfil, para cada vez que hagas un migration se ejecute el seed
   //hay que poner en que columna esta relacionado el usuario
   // hacer en el index oro boton para editar perfil y que te lleve a la ruta de editar perfil despues de haber trabajado con el modelo y el controlador del perfil
   // en el receta contoller hay que pasarle el id del usuario cuyo perfil queremos editar y vas a al controller de receta por que es en este controllador donde se muestra el index a donde siempre rediriges
  // crear el policy para el update de perfil cuando lo modifiques, para que el policy verifique el usuario hay que agregarle un modelocuando lo creas
    public function usuario(){

   return $this->belongsTo(User::class,'user_id' );
        // Get the user that owns the Perfil
   }



 }
