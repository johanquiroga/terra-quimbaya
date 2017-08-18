<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReportRequest;
use App\Models\EstadoCompra;
use App\Models\Informe;
use App\Models\Proveedor;
use App\Models\Comprador;

use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Yajra\Datatables\Facades\Datatables;

class InformeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $board_user = Auth::user()->tipoUsuario;
        $type = 'report';

        return view('reports.index', compact('type', 'board_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $board_user = Auth::user()->tipoUsuario;
        $type = 'report';

        $buyers = Comprador::all();
        $providers = Proveedor::all();

        $inicio = Carbon::now()->subMonth()->format('Y-m-d');
	    $final = Carbon::now()->format('Y-m-d');

        return view('reports.create', compact('type','board_user', 'providers', 'buyers', 'inicio', 'final'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateReportRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateReportRequest $request)
    {
        $type = $request->type;
	    $ids = $request->usuarios;
	    $tipoUsuario = $request->tipoUsuario;
	    $usuarios = null;
	    $aceptado = EstadoCompra::where('estado', 'aceptada')->get()->first();
	    $total = [];
	    $inicio = Carbon::createFromTimestamp(strtotime($request->fechaInicio))->toDateTimeString();
	    $final = Carbon::createFromTimestamp(strtotime($request->fechaCierre))->endOfDay()->toDateTimeString();
	    //dd($inicio, $final);
	    switch ($tipoUsuario) {
		    case 'Proveedores':
			    $usuarios = Proveedor::whereIn('id', $ids)->with([
				    'productos.compras' => function ($query) use ($aceptado, $inicio, $final) {
					    $query->where('fechaDeCompra', '>=', $inicio);
					    $query->where('fechaDeCompra', '<=', $final);
					    $query->where('idEstadoCompra', $aceptado->id);
				    },
				    'fotos',
				    'ubicacionFinca'
			    ])->get();
			    foreach ($usuarios as $usuario) {
				    $sum = 0.0;
				    foreach ($usuario->productos as $producto) {
					    $sum += $producto->compras->sum('valorTotal');
				    }
				    $total[$usuario->id] = $sum;
			    }
			    break;
		    case 'Compradores':
			    $usuarios = Comprador::whereIn('id', $ids)->with([
				    'compras' => function ($query) use ($aceptado, $inicio, $final) {
					    $query->where('fechaDeCompra', '>=', $inicio);
					    $query->where('fechaDeCompra', '<=', $final);
					    $query->where('idEstadoCompra', $aceptado->id);
				    },
				    'compras.product'
			    ])->get();
			    foreach ($usuarios as $usuario) {
				    $sum = $usuario->compras->sum('valorTotal');
				    $total[$usuario->id] = $sum;
			    }
			    break;
	    }

        if($type == 'Preview'){

            //dd($usuarios, $total);
            return view('reports.preview', compact('usuarios', 'total'));

        }
        elseif ($type == 'Submit'){

	        $path = 'reports/';

	        $report = Informe::firstOrNew([
		        'fechaGeneracion' => Carbon::now()->toDateTimeString(),
		        'path' => $path,
	        ]);
	        $report->admin()->associate(Auth::user()->idCC);
	        $report->save();

            $pdf = PDF::setOption('enable-javascript', true);
            $pdf->setOption('javascript-delay', 1000);
            $pdf->setOption('enable-smart-shrinking', true);
            $pdf->setOption('no-stop-slow-scripts', true);
            $pdf = PDF::loadView('reports.preview', compact('usuarios', 'total', 'report'))->setPaper('letter');

            $file_name = "$report->id"."_".str_replace([":","-"," "],["","_","_"], $report->fechaGeneracion).".pdf";
	        if(app()->environment() == 'local') {
		        $pdf->save(storage_path('app/') . $path . $file_name);
	        } else {
		        Storage::put("$path/$file_name", $pdf->output());
	        }

            return view('reports.download', compact('report'));

        }
        else return redirect(route('report::index'));
    }

    /**
     * Get the report and return the download.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $report = Informe::findOrFail($id);
	    $file_name = "$report->id"."_".str_replace([":","-"," "],["","_","_"], $report->fechaGeneracion).".pdf";
        //$path = storage_path('app/') . $report->path . $file_name;
	    $path = Storage::files("reports/$file_name");
	    dd($path);
        $headers = array(
	        'Content-Type' => 'application/pdf',
        );
        return response()->download($path, 'Informe'.$file_name, $headers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Return data to show in DataTable Reports
     *
     * @return mixed
     */
    public function anyData()
    {
        $reports = Informe::query()->with(array(
            'admin' => function($query) {
                $query->select('id','nombres','apellidos');
            },
        ));
        return Datatables::of($reports)->make(true);
    }
}
