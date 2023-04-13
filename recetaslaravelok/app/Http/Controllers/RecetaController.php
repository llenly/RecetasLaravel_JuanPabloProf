<?php


/* maneras de craer los controillers

class RecetaController extend Controller
{
   /* *En el controlador se hace la consulta a la DB y pasas el resultado de la consulta a la vista
    /* *
      Handle the incoming request.
     invoke para un solo metodo , y no hace falta llamar al metodo en el route solo llmas al controller
      @param  \Illuminate\Http\Request  $request
      @return \Illuminate\Http\Response

          public functio _invoke(Request $request)
    {
        hacer una consulta y pasar el resulatdo mediante el controller a la vista
        para leer esa consulta e imprimirla en la vista(index)trabajar en ese archivo

      $recetas = ['Receta Pizza', 'Receta Pasta','Receta Atipasta'];
      $categorias = ['Comida Italiana','Comida Mexicana', 'Comida Japones'];

 con la sintaxis with pasando una llave(string) y n valor(variable), doble with para pasarle dos valores
 el string es el identificador
        return view('recetas.index')
               ->with('recetas',$recetas)
               ->with('categorias',$categorias);


 otra manera de pasale la llave al controller para mostrar en la vista la consulta
 es lo mismo que arriba
        return view('recetas.index',compact('recetas','categorias'));
    }
}

*/

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;

use Intervention\Image\Facades\Image;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class RecetaController extends Controller
{
 /* usas el mtodo middleware para la utenticacion, que solo un usuario registrado tenga acceso a las paginas,
 y si no esta registrado te lleva a la pagina de accder
   este metodo  se usa medianre un constructor
   para proteger las rutas, del m iddleware, lo que va entre corchete son los action o metodos que quedan fuera de la protecciono sea abiertos
     */
     public function __construct()
     {
        $this->middleware('auth',['except'=> ['show','search']]);
     }


    /**
     * Display a listing of the resource.
     * esto bse crea cuando el model resorce -mcr
     * aqui vas a trabajar con cada metodo que va a cargar las diferentes vistas y en las resource vas a hacer referncia a estos metodos
     *
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //trabajar aqui con la relacion creada en el modelo user(relacionRecetas) para mostrar los datos guardados de la db por pantalla

      //  Auth::user()->relacionRecetas->dd();es lo mismo de abajo , esto devuelve un objeto, con todo lo escrito el usuario autenticado por eso se usa el auth
      //auth()->user()->relacionRecetas->dd();
     // el objreceta va a ser un objeto que guarda todas las recetas que guardo el usuario y a su vez va a ser ogual al usuario identificado ,para poder pasarle ese objeto a la vista e imprimirlo hacer el with o el compact con esta variable objeto creada y luego pasarla en la ruta
       $objrecetas = auth()->user()->relacionRecetas;//metodo relacion receta lo creas en la relacion que creas en el archivo user

           /*   CREAR LA RUTA DEL BOTON EDITAR PARA EDITAR EL PERFIL DEL USUARIO AUNTEICADO
             TRABAJAS CON LA FUNCION AUT PARA ENLAZAR EL ID DEL USURIO IDENTIFICADO PARA EDITAR EL PERFIL
              todo esto se hace despues de trabajar con el modelo u el controller y las tablas
             hay que pasarle la variable usuario para en el index blade tener acceso a la variable en la ruta creada
             para el boton de editar perfiles
             $usuario = auth()->user();  el objeto usuario va a ser igual al usuario identificado mediante la funcion auth
            ,para poder pasarle ese objeto a la vista e imprimirlo hacer el with o el compact con esta variable objeto creada y luego pasarla en la ruta */


            //PAGIACION DE LAS RECETAS
              //se usa el moedlo y haces un where conmo en sql,en la tabla recetas user_id guarda la referencia al usuario
              //en eloquent para paginar esta el get(trae todo ) y pagination solo el get con limite
              //para que se muestre el resto de las recetas en la vista del index, fuera de la tabla colocas el objeto que le haces el forecha en este caso objreceta y usas el metodo links()
              //$usuarioauth = auth()->user()->id; accedo al usuario que esta autenticado y luego al id de la receta
              $usuarioauth = auth()->user();
         //Aceder al usuario que dio me gusta y almacenar y mostrar las rcetas con likes e iterar los resultados
              //$meGusta = auth()->user()->meGusta; otra manera es hacerlo en el index


              $objrecetas = Receta::where('user_id', $usuarioauth->id)->paginate(3);

       //pasar ese objeto con un with o un compact para mostralo o imprimirlo en l vista(pantalla), ir al archivo recetas index y mostrar esta varible objrecetas
        // esto muestra la vista o pagina de recetas la principal o sea el index
        return view('recetas.index')
              ->with('objrecetas',$objrecetas)
              ->with('usuarioauth',$usuarioauth);
              // ->with('usuario',$usuario);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

       // hacer una consulta a la db , se hace en el controller o en el modelo dd es como un var dum y deteien la ejecucion, pluck saca solo los campos que pases como parametro
       //  DB::table('categoria_recetas')->get()->dd(); obtener los datos o la consulta sin un modelo
      // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre', 'id');

// hacer una consulta a la db mediante el modelo, primero creas el modelo en este caso CategoriaReceta, hay que importar la clase o el archivo (el modelo cread), luego iteras ese objeto en el
// create para msotar las categorias con modelo
        $categorias = CategoriaReceta::all(['id','nombre']);

        return view('recetas.create')->with('categorias', $categorias);
        //pagina o vista create recetas , tienes que crearlas tu las vistas  view
        //mostrar la consulta con el with o el compact pasandole como string el nombre de la variable que recoge la consulta y la var
        //para imprimir la consulta en la vista ir al archivo blade la vista(create.blade en este caso)
    }

    /**
     * Store a newly created resource in storage.
     *  el request es lo que se envia al store para lamecenar los datops enviados del form
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all() );
        //este metodo trabaja con las solicitudes o request del form para insertar los datos del form a la base de dato
        //duda con dd , pone que es como unn vardumn
        //hacer las validaciones de los campos del form en la variable data con la funcion validate
        //dd($request->all() ); enviar el titulo a la vusta por medio del request


// VALIDACIONES  LA VARIABLE DATA GUARGA TODOS LOS DATOS DE LA REQUEST
        $data = request()->validate([
           //nombre del campo a validar (lo sacas del for de cada campo), y definas la reglas de validacion para cada campo
           //luego en la vista creas el mensaje de error

           'titulo'=>'required|min:6',
           'categoria'=>'required',
           'preparacion'=>'required',
           'ingredientes'=>'required',
           'imagen'=>'required',

        ]);

     //GUARDAR IMAGEN EL SERVIDOR , upload-receta es el nombre la carpeta donde vas a guardar las imgenes,
     //correr el comando php artisan storage:link para crear una url visible
     //dd($request['imagen']->store('upload-recetas', 'public') );
     // dd($request->all());

     //OBTENER LA RUTA DE LA IMAGEN
       $ruta_imagen = $request['imagen']->store('upload-recetas','public');

    /* RESIZE DE LA IMAGEN,
   1 intsalar con composer la libreria , comando composer required intervention/imgen
   2 crear una varible que tiene la imagen original la ahce mas pequeña y la guarda en el servidor , la url sigue siendo  la misma
   3 importar la clase de intervention/image Image:: desde el FACADES, SON FUNCIONES
    */
 $img = Image::make( \public_path("storage/{$ruta_imagen}") )->fit(600,550);
 $img->save();

// hay que importar la clase DB que en este caso es un fasac de laravel(funcion automatica de laver compleja)
//INSERTAR EN LA DB los datos del form, segun que datos es el nombre del for que hayas puesto en el form este es para la tabla recetas
//tiene que tener los mismos campos que la tabla recetas

//ALMACENAR EN LA DB(SIN MODELO)
      /*   DB::table('recetas')->insert ([
            'id'=>$data['id'],ESTE NO VA
            'titulo' =>$data['titulo'],
           'ingredientes' =>$data['ingredientes'],
            'preparacion' =>$data['preparacion'],
           'imagen' => $ruta_imagen,
            'user_id' =>Auth::user()->id, //helper auth devuelve el usuario que esta autenticado o registrado
            'categoria_id' =>$data['categoria'],
        ]);
 */

//ALMACENAR DATOS DE LAS RECETAS CON MODELO
  // primero tomar siempre el usuarrio si esta utenticado o no y ver quien es , despues acceder al objetpo del usuario
  // y despues accedes a sus datos (en este caso las recetas que creo ) con el objeto que creaste en el modelo user y la relacion de ese modelo y esa tabla
  //insertar o crear los campos son los mismo que tienes en la tabla create recetas

     auth()->user()->relacionrecetas()->create([
        'titulo' =>$data['titulo'],
        'ingredientes' =>$data['ingredientes'],
        'preparacion' =>$data['preparacion'],
        'imagen' => $ruta_imagen,
        'categoria_id' =>$data['categoria'],
     ]);

// esto arroja un error porque en modelo de recetas tienes que tener los campos que vas a inyectar los mismo que el form
//, por lo que tienes que crearlos en el modelo nuevo que creaste de Recetas los  (fillables) ir al modelo recetas y poner cada uno de los campos en los fillable



// despues de insertar los datos en el db , que redireccione al index te redirige a una action, no a un route
    return redirect()->action('RecetaController@index');


       // dd( $request->all() );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $objreceta)
    {
       //Obtener si el usuario actual le gusta la receta y esta autenticado
       //like va a retornar ture o false
       //contains helper de laraverl par aver si existe algun elemento o no en el array
       $like = ( auth()->user() ) ? auth()->user()->meGusta->contains('objreceta->id') : false;

       //Pasa la catidad de likes a la vista, count helper de laravel para ver cuantos elementos hay en un array
       $likes = $objreceta->likes->count();

        //  return $receta;
        //consultar la base de datos y ver las rceta
        //esto esta conectado con el id de las recetas
        //otro metodo para obtener la receta, para eso en la funcion del metodo quitar las clase y dejar solo la variable o identificador
       // $receta = Receta::find($receta); con el metodo findOrFail, si no existe la rece saca un 404
       //return $receta; es lo mismo que arriba pero mas actual
// 1 crear una vista show pra esta accion o metdo y retornar la vista duda en porque va receta en el compact
  return view('recetas.show', compact('objreceta', 'like', 'likes'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $objreceta)
    {
       // return "desde edit";
        //comprobar el polucy para las vista
        $this->authorize('view', $objreceta);

        //para que esten disponibles las categorias en esta vista
        $categorias = CategoriaReceta::all(['id','nombre']);
        //creas la ruta con el controller primero en el archivo web, no entiendo por que aqui va categorias , sino lo pnes te sale un error
        return view('recetas.edit', compact('categorias','objreceta'));


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
        //crear la ruta en el archivo web, luego enlazar esa ruta en el boton, crear la vista y trabajar con ella(validar) y guardar en la base de datos
        //return objreceta; te saca en la vista todo el contenido de la rceta
        //Revisar el policy
        $this->authorize('update',$objreceta);


// VALIDACIONES  LA VARIABLE DATA GUARGA TODOS LOS DATOS DE LA REQUEST PUT DEL UPDATE
        $data = request()->validate([
    //nombre del campo a validar (lo sacas del for de cada campo), y definas la reglas de validacion para cada campo
    //luego en la vista creas el mensaje de error

    'titulo'=>'required|min:6',
    'categoria'=>'required',
    'preparacion'=>'required',
    'ingredientes'=>'required',

 ]);
    //ASIGNAR LOS VALORES DE LA RECETA RESCRIBIRLA Y GUARDARLA
     $objreceta->titulo = $data['titulo'];
     $objreceta->preparacion = $data['preparacion'];
     $objreceta->ingredientes = $data['ingredientes'];
     $objreceta->categoria_id = $data['categoria'];// solo categoria porque el name de la data del form de edit es categoria

    //detectar si el usuario sube una nueva imagen, el name es el mismo que esta en el campo de la imagen en el form de edit
    if(request('imagen')){
        //OBTENER LA RUTA DE LA IMAGEN y guardarla
        $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');
        //RESIZE DE LA IMAGEN,
        $img = Image::make( \public_path("storage/{$ruta_imagen}") )->fit(600,550);
        $img->save();

        //asignar la nueva img subida al objeto de recetas update nuevo(actualizar la foto de la receta editada)
        $objreceta->imagen = $ruta_imagen;

        }


       $objreceta->save();//guarda tdo los cambios

     //REDIRECCIONAR UNA VEZ QUE SE GUARDE LOS DATOS, si usas el action usas el  nombre del controller
       return redirect()->action('RecetaController@index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $objreceta)
    {
         return "eliminando";
        //EJECUTAR O AUTORIZAR EL POLICY O SEA LA VALIDACION, primero configuara el metodo delete en el policy
        $this->authorize('delete',$objreceta);

        //ELIMINAR LA RECETA ACTUAL EN CASO DE QUE CUMPLA LA CONDICION(el usuario autenticado , el que la creo es el que la borrando)
        $objreceta->delete();


      return redirect()->action('RecetaController@index');

    }

    //metodo para el buscador de recetas, 'buscar' esto viene del campo del form, agregar en el middleware este metodo para que un susario no aut pueda buscar
    public function search( Request $request)
    {

         $busqueda = $request->get('buscar');

        // return  $busqueda ;
        //  $busqueda = $request['buscar'];es lo mismo que arriba
        //Consultar lo que viene de la db por la busqueda del usuario, usar el operador like, funciona iagul con la instancia objreceta, si hay mas de tres rceetas no muestra el paginador
        $recetasagrupada = Receta::where('titulo', 'like', '%' . $busqueda . '%')->paginate(3);
        //para que muestre todas las recetas de esa busqueda , en paginador no lo muestra pierde la referencia  duda??? agrega algo al quey string
        $recetasagrupada->appends(['buscar' =>$busqueda]);

        // return $busqueda;
        return view('busquedas.show', compact('recetasagrupada', 'busqueda'));
    }
}
