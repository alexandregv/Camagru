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

	public function register()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'GET')
			$this->render('Users#register');
		else if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if (!empty(trim($_POST['email']) && !empty(trim($_POST['username'])) && !empty(trim($_POST['password'])) && !empty(trim($_POST['firstname'])) && !empty(trim($_POST['lastname']))))
			{
				$hash = hash('whirlpool', 'grumaca' . $_POST['password']);
				$db   = \App\Database::getInstance();
				$user = $db->query("SELECT username, email FROM users WHERE email = '{$_POST['email']}' OR username = '{$_POST['username']}'", [], 1);
				if ($user == false)
				{
					$res  = $db->query("INSERT INTO users (`username`, `email`, `passHash`, `firstname`, `lastname`, `confirmToken`) VALUES ('{$_POST['username']}', '{$_POST['email']}', '$hash', '{$_POST['firstname']}', '{$_POST['lastname']}', 'confirmed')", [], 0);
					$user = $db->query("SELECT id, username FROM users WHERE email = '{$_POST['email']}'", [], 1);
					if ($user != false)
					{
						$_SESSION["loggedin"] = true;
						$_SESSION["id"] = $user['id'];
						$_SESSION["username"] = $user['username'];
						$this->redirect('Pages#home');
					}
					else
					{
						$this->errors[] = 'invalid_email';
						$this->render('Users#register');
					}
				}
				else
				{
					if ($user['email'] == trim($_POST['email'])) $this->errors[] = 'busy_email';
					if ($user['username'] == trim($_POST['username'])) $this->errors[] = 'busy_username';
					$this->render('Users#register');
				}
			}
			else
			{
				$this->errors = ['missing_email', 'missing_password'];
				$this->render('Users#register');
			}

		}
	}

}
