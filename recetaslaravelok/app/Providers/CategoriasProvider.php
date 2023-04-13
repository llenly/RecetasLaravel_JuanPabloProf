<?php

namespace App\Providers;
use View;
use App\CategoriaReceta;
use Illuminate\Support\ServiceProvider;

class CategoriasProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //se eecuta todo cuando la aplicacion esta lista
        //aqui utilizas lo que vas a usar para consultar la db y mostarlo en la vista  en este caso las categorias
            View::composer('*', function ($view) {
                //mostrar las categorias en todas las vistas haciendo una consulta a la db de la tabla categorias
                // $view->with('categorias', "las categorias van aqui");
                $categorias = CategoriaReceta::all(); //le pasas la categorias de la db y las traes todas
                $view->with('categorias', $categorias);

            });
    }
}
