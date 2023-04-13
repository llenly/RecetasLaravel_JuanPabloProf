<?php

namespace App\Policies;

use App\Receta;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecetaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Receta  $receta
     * @return mixed
     */
    public function view(User $user, Receta $objreceta)
    {
        //validacion para que solo el usuario autenticado la vista , estas trabajando con el emtodo edit del controller respectivo que es el de receta
          return $user->id === $objreceta->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Receta  $receta
     * @return mixed
     */
    public function update(User $user, Receta $objreceta)
    {    //te crea la variable receta pero yo la tengo definida posteriormente como objerceta
        //revisa si el usuario autenticado es el mismo que creo la rceta, aqui tienes disponible lo que haya en modelo user y receta  los fillable
        // y lo que hayas definido en tu migracion, user_id es la rererencia a la tabla usuario en la migracion
        //luego hay que ir al controller y revisar el policy cumpla la condicion esta

        return $user->id===$objreceta->user_id;

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Receta  $receta
     * @return mixed
     */
    public function delete(User $user, Receta $objreceta)
    {
        //asegurar que el usuario que lo elimino es el que creo la receta(revisa la autenticacion del usuario) , es una validacion de seguridad
        return $user->id===$objreceta->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Receta  $receta
     * @return mixed
     */
    public function restore(User $user, Receta $receta)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Receta  $receta
     * @return mixed
     */
    public function forceDelete(User $user, Receta $receta)
    {
        //
    }
}
