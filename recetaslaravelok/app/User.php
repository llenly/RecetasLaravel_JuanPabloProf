<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *b fillable es obligatorio poner todos los campos que va a tener tu tabla de user y si creas un nuevo modelo
     * para una tabla nueva ejemplo categorias o recetas
     *tienes que pasarle estos campos tambien almodelo creado
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','url',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //CREAR PERFIL CUANDO SE CREE UN USUARIO NUEVO
    //EVENTO(hay muchos buscar bibliografia de eloquent ) DE ELOQUENT QUE SE EJECUTA CUANDO SE CREA UN USUARIO
      protected static function boot(){
          parent::boot();

          //asignar perfil una vez se haya creado un usuario nuevo, hicimos esto mismo para crear las recetas con el mismo metodo de eloquent en el recetacontroller
          static::created(function ($user) {
              $user->perfil()->create(); //esto crea un perfil cada vez que creas un nuevo usuario
          });
      }




 /* creando la relacion entre el modelo usuario y recetas ELOQUENT ORM
  trabaja con os modelos para guardar los datos en la db si codigo sql
  no necesitas importar la clase del modelo que vas relacionar
  eloquebt tiene funciones propias para las relaciones de tablas y modelos
  uno a mucho es este caso hasMany
  RELACION DE 1:N DE USUARIO A RECETA
  para interactuar con la base de datos (como si escribieras codigo sql)usas tinker en la consola
  esto te sirve para el siguiente paso que es mostrar los datos (las recetas en este caso por pantalla)ir al controller y trabajar con el metodo index
  sobre la autenticacion llamara  esta relacion creada aqui  en el metodo store
   y haces la consulta a la db desde el modelo y la relacion que hayas creado con ese modelo en este caso es relacionrecetas */
 //RELACION DE USUARIOS A RECETAS
 public function relacionrecetas()
 {

     return $this->hasMany(Receta::class);
 }

 //CREANDO LA RELACION USUARIO PERFIL DE UNO A UNO , PRIMERO HACER EL MODELO PERFIL Y LUEGO LA TABLA PERFIL CON SUS CAMPOS
// algunas veces quieres una relacion inversa , abrir el perfil y que ese perfil retorne la informacion del usuario , hacer la relacion en el modelo perfil
    public function perfil(){
        return $this->hasOne(Perfil::class);
    }

//relacion inversa  aqui es recetas que el usuario le ha dado me gusta
//hacer la relacion en el componete de receta para ver cuantas recetas el iusuario le da like ,'recetas_id','user_id'
  public function meGusta()
  {
    return $this->belongsToMany(Receta:: class, 'likes_receta');
  }

}
