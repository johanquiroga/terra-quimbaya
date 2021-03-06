<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Http\Requests\CreateMessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class LandingController extends Controller
{

	public function index()
	{

    }

	public function store(CreateMessageRequest $request)
	{
		$message = Message::create([
			'name' => $request->name,
			'email' => $request->email,
			'message' => $request->message
		]);

		return redirect(route('landing'))->with('message-success', 'Gracias por tu mensaje!');
    }


	public function download(Request $request)
	{
		if ($request->platform == 'android'){
			$download = new Download;

			$download->platform = $request->platform;

			$download->save();

			return redirect(config('app.android'));
		} else if ($request->platform == 'web') {
			$download = new Download;

			$download->platform = $request->platform;

			$download->save();

			return redirect(route('home'));//http://devenv.cje8szvmx3.us-west-2.elasticbeanstalk.com');
		} else {
			return back()->with('message-error', 'Lo sentimos, aún no contamos con aplicativo para el dispositivo indicado');
		}
    }
}
