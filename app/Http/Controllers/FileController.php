<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{

	public function get($filename, $download = false)
	{
		if(Storage::has($filename)) {
			$file = Storage::get($filename);
			$type = Storage::mimeType($filename);

			if($download) {
				$name = "Informe_" . substr(strstr($filename, "/"), 1);
				return response($file, 200)
					->header('Content-Type', $type)
					->header("Content-Disposition", "attachment; filename='$name'");
			}

			return response($file, 200)->header('Content-Type', $type);
		} else {
			abort(404, "Archivo no encontrado");
		}
    }
}
