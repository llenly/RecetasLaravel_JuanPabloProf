<?php

namespace App\Http\Controllers;

use App\Perfil;
use App\Receta;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
/*

      Display a listing of the resource.

      @return \Illuminate\Http\Response

    public function index()
    {

    }


      Show the form for creating a new resource.

      @return \Illuminate\Http\Response

    public function create()
    {

    }

    /*
     Store a newly created resource in storage.

      @param  \Illuminate\Http\Request  $request

     @return \Illuminate\Http\Response

    public function store(Request $request)
    {

    }
 */
    //PROTEGER QUE EL USUARIO ESTE AUTENTICADO SI NO MANDAR A REGISTRARSE
      public function __construct()
       {
          $this->middleware('auth', ['except'=>'show']);
       }
    /**
     * Display the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
     public function show(Perfil $perfil)
    {

        //return $perfil
        //OBTENER LAS RECETAS CON PAGINACION, desde el modelo de recetas del modelo perfil, hay que importar el modelo receta para tener acceso al metodo
        //modelo de receta donde user_id cada receta tiene un user_id, obtines el perfil del usurio en el mpdelo de perfil
        //luego pasarle con el compact le pasamos la var
        $objrecetas = Receta::where('user_id', $perfil->user_id)->paginate(3);



        //crear una vista para mostrar los perfiles, IMPORTAR EN LA VISTA EN LAYOUTS.APP Y CREAR LAS @SECTION
       // return $perfil;
       return view('perfiles.show', compact('perfil','objrecetas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {

        //que el usuario que este viendo el perfil este auth
        //ejecutar policy para que un usuario no autenticado no puede ver el perfil que no sea de el, el policy bloque la vista editar si el usuario no es el utenticado y lo comprueba aqui en el metodo
           $this->authorize('view', $perfil);

        //aqui trabajas con el metodo edit para editar el perfil del usuario autenticado
        // tienes que crear la vista, importar el layout e inyectar el yields(@section con el nombre del yiels o area)
        //para tener la informacion hay que hacer un compact a la variable perfil o la que este, para imprimirla en la vista
        return view('perfiles.edit', compact ('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {
        //dd($data);
        //EJECUTAR EL POLICY(CAPA DE SEGUIRDAD)
           $this->authorize('update',$perfil);

        //Validar la ebtrada de los datos
           $data = request()->validate([
               'nombre'=>'required',
                'url' => 'required',
                'biografia' => 'required'

           ]);

        //Validar si el usurio sube una imagen
        // dd( $request['imagen']);
             if( $request['imagen']){
               //  return "Si se subio una imagen";
                   //OBTENER LA RUTA DE LA IMAGEN y guardarla
        $ruta_imagen = $request['imagen']->store('upload-perfiles', 'public');
        //RESIZE DE LA IMAGEN,
        $img = Image::make( public_path("storage/{$ruta_imagen}") )->fit(600,600);
        $img->save();

        //crear un array de imagen, variable se crea si subes una imagen
        $array_imagen = ['imagen' => $ruta_imagen];
             }/* else{
                 return "No se subio una imagen";
             } */

        //ASIGNAR NOMBRE Y URL al usuario, una vez que guardas la informacion del nuevo usuario en la tabla perfil hay que eliminarla , porque estos campos no estan en la tabla perfil y marca un error
        //dd($data);
       auth()->user()->url = $data['url'];
       auth()->user()->name = $data['nombre'];
       auth()->user()->save();
        //ELIMINAR campos url y name de la data parapoder guardarlos en la tabla perfiles (que no tine estos campos)
          unset($data['url']);
         unset($data['nombre']);
        // return $data;aqui solo saca la biografia , elimina el nombre y la url
      //return $data;ok modifica y elimina los campos url y nombre de la variable data y solo muestra la biografia

        //Guardar  y actualizarla informacion en la tabla perfil

        //ASIGNAR BIOGRAFIA E IMAGEN y guaradr el array con la imagen subida , se le va a agregar a data
        auth()->user()->perfil()->update( array_merge(
          //  $perfil->biografia = $data['biografia'],
            $data,
            $array_imagen ?? []
        ) );
        $perfil->save();

        //Redireccionar RecetaController@index es nuestro listado de receta
       // crear la ruta, hacer la vista,
       return redirect()->action('RecetaController@index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perfil $perfil)
    {
        //
    }
}
