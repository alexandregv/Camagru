<?php

namespace App\Middlewares;
use \App\Helpers;

class NoAuthMiddleware extends Middleware
{
	public function call(string &$body)
	{
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
		{
			Helpers::flash('danger', 'Vous êtes déjà inscrit et connecté !');
			return $this->router->redirect('Users#profile');
		}
	}
}

?>
