<?php

namespace App\Http\Controllers\Auth;

use App\Models\Atributo;
use App\Models\Comprador;
use App\Models\DireccionResidencia;
use App\Models\FrecuenciaCompraCafe;
use App\Models\NivelEstudios;
use App\Models\Usuario;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * @var string
     */
//    protected $redirectPath = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getLogout', 'getCountry', 'getDepartment', 'getCity']]);
    }

    /**
     *
     */
    private function atributos()
    {
        $attrRules = array();
        $attributes = Atributo::all(['id', 'nombreAtributo', 'opciones']);
        foreach ($attributes as $attribute) {
            $attrRules[$attribute->nombreAtributo] = 'required';
            if(!is_null($attribute->opciones)) {
                $attrRules[$attribute->nombreAtributo] = $attrRules[$attribute->nombreAtributo] . '|in:' . $attribute->opciones;
            }
        }
        return $attrRules;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'id' => ['required','min:8','max:10','unique:comprador,id,NULL,id,estado,1','regex:/^(\d{8}|\d{10})$/'],
            'nombres' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'apellidos' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'email' => 'required|email|max:45|unique:usuario|unique:comprador,correoElectronico,NULL,id,estado,1',
            'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'telefono' => 'required|min:7|max:10|regex:/^\d{7,10}$/',
            'idFrecuenciaCompraCafe' => 'required|exists:frecuenciaCompraCafe,id',
            'idNivelEstudios' => 'required|exists:nivelEstudios,id',
            'direccion' => 'required|max:60',
            'direccionAuxiliar' => 'max:60',
            'codigoPostal' => 'required|max:10|regex:/^\d{0,10}$/',
            'ciudad' => 'required|max:45',
            'departamento' => 'required|max:45',
            'pais' => 'required|max:45'
        ];
        $rules_attributes = array_merge($rules, $this->atributos());

        return Validator::make($data, $rules_attributes);
    }

    private function storeNewBuyer(array $data)
    {
	    $comprador = Comprador::firstOrNew([
		    'id' => $data['id'],
		    'nombres' => $data['nombres'],
		    'apellidos' => $data['apellidos'],
		    'correoElectronico' => $data['email'],
		    'contraseña' => bcrypt($data['password']),
		    'telefono' => $data['telefono'],
	    ]);

	    $direccion = new DireccionResidencia([
		    'direccion' => $data['direccion'],
		    'direccionAuxiliar' => $data['direccionAuxiliar'],
		    'codigoPostal' => $data['codigoPostal'],
		    'ciudad' => $data['ciudad'],
		    'departamento' => $data['departamento'],
		    'pais' => $data['pais']
	    ]);

	    $nivel = NivelEstudios::find($data['idNivelEstudios']);
	    $comprador->nivelEstudios()->associate($nivel);

	    $frecuencia = FrecuenciaCompraCafe::find($data['idFrecuenciaCompraCafe']);
	    $comprador->frecuenciaCompraCafe()->associate($frecuencia);

	    $comprador->save();

	    $comprador->direccion()->save($direccion);

	    return $comprador;
    }

    private function storeDeletedBuyer(Comprador $comprador, array $data)
    {
	    if($comprador->estado == 0) {
		    $comprador->estado = 1;

		    $comprador->fill([
			    'id' => $data['id'],
			    'nombres' => $data['nombres'],
			    'apellidos' => $data['apellidos'],
			    'correoElectronico' => $data['email'],
			    'contraseña' => bcrypt($data['password']),
			    'telefono' => $data['telefono'],
		    ]);

		    $comprador->direccion->fill([
			    'direccion' => $data['direccion'],
			    'direccionAuxiliar' => $data['direccionAuxiliar'],
			    'codigoPostal' => $data['codigoPostal'],
			    'ciudad' => $data['ciudad'],
			    'departamento' => $data['departamento'],
			    'pais' => $data['pais']
		    ])->save();
	    }

	    $nivel = NivelEstudios::find($data['idNivelEstudios']);
	    $comprador->nivelEstudios()->associate($nivel);

	    $frecuencia = FrecuenciaCompraCafe::find($data['idFrecuenciaCompraCafe']);
	    $comprador->frecuenciaCompraCafe()->associate($frecuencia);

	    $comprador->save();

	    return $comprador;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $data
     * @return Usuario
     */
    protected function create(array $data)
    {
        //dd($data);
        //Create Comprador and DireccionResidencia
        $comprador = Comprador::find($data['id']);
        if(is_null($comprador)) {
        	$comprador = $this->storeNewBuyer($data);
        } else {
        	$comprador = $this->storeDeletedBuyer($comprador, $data);
        }

        $attributes = Atributo::all(['id', 'nombreAtributo']);
        foreach($attributes as $attribute) {
            $comprador->atributos()->attach($attribute->id, ['valorAtributo' => $data[$attribute->nombreAtributo]]);
        }

        return Usuario::create([
            'idCC' => $data['id'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'tipoUsuario' => 'comprador'
        ]);
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        $role = Auth::user()->tipoUsuario;
        $path = '/';
        switch ($role) {
            case 'root':
                $path = route('profile::profile');//'/administradores';
                break;
            case 'comprador':
                $path = '/';
                break;
            case 'admin':
                $path = route('profile::profile');
                break;
        }
        return $path;
    }

	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getRegister()
	{
		$nivelEstudios = NivelEstudios::all();
		$frecuenciaCompraCafe = FrecuenciaCompraCafe::all();
		$attributes = Atributo::all(['id', 'nombreAtributo', 'descripcionAtributo', 'opciones']);
		foreach ($attributes as $attribute) {
			if(!is_null($attribute->opciones))
				$attribute->opciones = explode(",", $attribute->opciones);
		}
		return view('auth.register', compact('nivelEstudios', 'frecuenciaCompraCafe', 'attributes'));
	}

    /**
     * Return an array of all available countries
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountry(Request $request)
    {
        if($request->ajax()) {
            $countries = config('registration_address.countries');
            return response()->json($countries);
        }
    }

    /**
     * Return an array of all departments (states) for a given country
     *
     * @param Request $request
     * @param         $country
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepartment(Request $request, $country)
    {
        if($request->ajax()) {
            $departments = config('registration_address.departments.' . $country);
            return response()->json($departments);
        }
    }

    /**
     * Return an array of all cities of a given department
     *
     * @param Request $request
     * @param         $department
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCity(Request $request, $department)
    {
        if($request->ajax()) {
            $cities = config('registration_address.cities.' . $department);
            return response()->json($cities);
        }
    }
}
