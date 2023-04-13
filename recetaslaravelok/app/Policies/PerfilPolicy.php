<?php

namespace App\Policies;

use App\Perfil;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PerfilPolicy
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
        //zona premieun delproyecto , crear rol de usuario mas basico y prohibir el acceso a todo el modelo de lo que se premiun exceto a esto , duda ??ç
        //blouqea ciertas vistas , bloquear que alguien visite el perfil que no sea el auteniticado

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Perfil  $perfil
     * @return mixed
     */
    public function view(User $user, Perfil $perfil)
    {
         return $user->id === $perfil->user_id;
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
     * @param  \App\Perfil  $perfil
     * @return mixed
     */
    public function update(User $user, Perfil $perfil)
    {
        // solo usamos el update para revisar si el usuario autenticado es el que decea modificar el perfil
        return $user->id === $perfil->user_id;


    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Perfil  $perfil
     * @return mixed
     */
    public function delete(User $user, Perfil $perfil)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Perfil  $perfil
     * @return mixed
     */
    public function restore(User $user, Perfil $perfil)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Perfil  $perfil
     * @return mixed
     */
    public function forceDelete(User $user, Perfil $perfil)
    {
        //
    }
}
