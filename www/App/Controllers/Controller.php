<?php

namespace App\Controllers;

class Controller
{
	public function render($full)
	{
		$full = explode('#', $full);
		require "App/Views/$full[0]/$full[1].php";
	}

}

?>
