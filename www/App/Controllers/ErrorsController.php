<?php

namespace App\Controllers;

class ErrorsController extends Controller
{
	public function _404()
	{
		$this->render('Errors#404');
	}

}
