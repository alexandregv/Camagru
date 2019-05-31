<?php

namespace App\Models;

class User extends Model
{
	protected $_id				= 00;
	protected $_username		= '';
	protected $_firstname		= '';
	protected $_lastname		= '';
	protected $_passHash		= '';
	protected $_email			= '';
	protected $_confirmToken	= '';
	protected $_posts			= [];
	protected $_likedPosts		= [];

	public function getProfilePicture(): string
	{
		$file = '/public/assets/img/profile_pictures/' . $this->getId() . '.png';
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . $file))
			return $file;
		else
			return 'https://bulma.io/images/placeholders/128x128.png';
	}
}

?>
