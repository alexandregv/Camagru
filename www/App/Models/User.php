<?php

namespace App\Models;

class User extends Model
{
	protected $_id					=  0;
	protected $_username			= '';
	protected $_firstname			= '';
	protected $_lastname			= '';
	protected $_passHash			= '';
	protected $_email				= '';
	protected $_confirmToken		= '';
	protected $_resetToken			= '';
	protected $_likeNotifications	=  1;
	protected $_admin				=  0;

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
