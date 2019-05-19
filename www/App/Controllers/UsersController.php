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

	public function profile()
	{
		$this->user = \App\Models\User::get($_SESSION['id']);

		if ($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if ($this->user == false)
				$this->errors[] = 'invalid_user_id';
			$this->render('Users#profile');
		}
		else if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if ($this->user != false)
			{
				if ($this->user->getPassHash() === hash('whirlpool', 'grumaca' . trim($_POST['old_password'])))
				{
					$username	 = $this->user->getUsername();
					$email		 = $this->user->getEmail();
					$firstname = $this->user->getFirstname();
					$lastname	 = $this->user->getLastname();
					$passHash	 = $this->user->getPassHash();

					$skip = false;
					if (!empty($_POST['email']) && trim($_POST['email']) != '' && trim($_POST['email']) != $this->user->getEmail())
					{
						$exists = \App\Database::getInstance()->query("SELECT username FROM users WHERE email = '{$_POST['email']}'", [], 1);
						if ($exists !== false)
						{
							$skip = true;
							$this->errors[] = 'busy_email';
						}
					}
					if (!empty($_POST['username']) && trim($_POST['username']) != '' && trim($_POST['username']) != $this->user->getUsername())
					{
						$exists = \App\Database::getInstance()->query("SELECT username FROM users WHERE username = '{$_POST['username']}'", [], 1);
						if ($exists !== false)
						{
							$skip = true;
							$this->errors[] = 'busy_username';
						}
					}

					if ($skip == false)
					{
						foreach (['username', 'email', 'firstname', 'lastname'] as $attr)
							if (!empty($_POST[$attr]) && trim($_POST[$attr]) != '')
								${$attr} = trim($_POST[$attr]);

						if (!empty($_POST['new_password']) && trim($_POST['new_password']) != '')
							$passHash = hash('whirlpool', 'grumaca' . trim($_POST['new_password']));

						$res = \App\Database::getInstance()->query("UPDATE users SET username = '$username', email = '$email', firstname = '$firstname', lastname = '$lastname', passHash = '$passHash' WHERE id = '{$_SESSION['id']}'", [], 0);
						//TODO: ^ use ORM ^ 
						$this->redirect('Users#profile');
					}
				}
				else $this->errors[] = 'invalid_old_password';
			}
			else $this->errors[] = 'invalid_user_id';

			if ($this->user == false)
				$this->errors[] = 'invalid_user_id';
			$this->render('Users#profile');
		}
	}

	public function login()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'GET')
			$this->render('Users#login');
		else if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if (!empty(trim($_POST['username']) && !empty(trim($_POST['password']))))
			{
				$hash = hash('whirlpool', 'grumaca' . $_POST['password']);
				$user = \App\Database::getInstance()->query("SELECT id, username, passHash FROM users WHERE username = '{$_POST['username']}'", [], 1);
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
					$this->errors[] = 'invalid_username';
					$this->render('Users#login');
				}
			}
			else 
			{
				$this->errors = ['nissing_email', 'nissing_password'];
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
			if (!empty(trim($_POST['email']) && !empty(trim($_POST['username'])) && !empty(trim($_POST['password'])) && !empty(trim($_POST['password_confirm'])) && !empty(trim($_POST['firstname'])) && !empty(trim($_POST['lastname']))))
			{
				if (trim($_POST['password']) == trim($_POST['password_confirm']))
				{
					$pass = trim($_POST['password']);
					if (preg_match('#[0-9]+#', $pass) && preg_match('#[A-Z]+#', $pass) && preg_match('#[a-z]+#', $pass) && preg_match('/[!@#$%^&*\(\){}\[\]:;<,>.?\/\\~`]+/', $pass))
					{
						$hash = hash('whirlpool', 'grumaca' . $pass);
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
						$this->errors[] = 'invalid_password';
						$this->render('Users#register');
					}
				}
				else
				{
					$this->errors[] = 'passwords_mismatch';
					$this->render('Users#register');
				}
			}
			else
			{
				if (empty(trim($_POST['email'])))     		  $this->errors[] = 'invalid_email';
				if (empty(trim($_POST['username'])))  		  $this->errors[] = 'invalid_username';
				if (empty(trim($_POST['password'])))  		  $this->errors[] = 'invalid_password';
				if (empty(trim($_POST['firstname']))) 		  $this->errors[] = 'invalid_firstname';
				if (empty(trim($_POST['lastname'])))  		  $this->errors[] = 'invalid_lastname';
				if (empty(trim($_POST['password_confirm'])))  $this->errors[] = 'invalid_password';
				$this->render('Users#register');
			}

		}
	}

}
