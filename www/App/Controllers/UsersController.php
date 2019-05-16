<?php

namespace App\Controllers;

class UsersController extends Controller
{
	public $errors = [];

	//public function index()
	//{
	//	$this->render('Users#index');
	//}

	//public function show($id)
	//{
	//	$this->render('Users#show');
	//}

	public function login()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'GET')
			$this->render('Users#login');
		else if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if (!empty(trim($_POST['email']) && !empty(trim($_POST['password']))))
			{
				$hash = hash('whirlpool', 'grumaca' . $_POST['password']);
				//$user = \App\Database::getInstance()->query("SELECT * FROM users WHERE email = '{$_POST['email']}' AND passHash = '$hash'", [], 1);
				$user = \App\Database::getInstance()->query("SELECT * FROM users WHERE email = '{$_POST['email']}'", [], 1);
				if ($user != false)
				{
					if ($user['passHash'] === $hash)
					{
						$_SESSION["loggedin"] = true;
						$_SESSION["id"] = $user['id'];
						$_SESSION["username"] = $user['username'];
						$this->redirect('Pages#home');
					}
					else
					{
						$this->errors[] = 'invalid_password';
						$this->render('Users#login');
					}
				}
				else
				{
					$this->errors[] = 'invalid_email';
					$this->render('Users#login');
				}
			}
			else 
			{
				$this->errors = ['missing_email', 'missing_password'];
				$this->render('Users#login');
			}
		}
	}
	
	public function logout()
	{
		session_destroy();
		$this->redirect('Pages#home');
	}

	//public function register()
	//{
	//	$this->render('Users#register');
	//}

}
