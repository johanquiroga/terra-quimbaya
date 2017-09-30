<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

	public function get($filename, $download = false)
	{
		if(Storage::has($filename)) {

			if($download) {
				$file = Storage::get($filename);
				$type = Storage::mimeType($filename);

				$name = "Informe_" . substr(strstr($filename, "/"), 1);
				return response($file, 200)
					->header('Content-Type', $type)
					->header("Content-Disposition", "attachment; filename='$name'");
			} else {
				if(app()->environment() == 'local') {
					$file = Storage::get($filename);
					$type = Storage::mimeType($filename);

					return response($file, 200)->header('Content-Type', $type);
				} else {
					return Storage::url("$filename");
				}
			}

			//return response($file, 200)->header('Content-Type', $type);
		} else {
			abort(404, "Archivo no encontrado");
		}
    }
}
