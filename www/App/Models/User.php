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
		return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->getEmail()))) . '?default=https%3A%2F%2Fbulma.io%2Fimages%2Fplaceholders%2F128x128.png';
	}
}

?>
