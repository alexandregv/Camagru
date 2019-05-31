<?php

namespace App\Models;

class Post extends Model
{
	protected $_id					= 00;
	protected $_creator_id	= 00;
	protected $_image				= '';
	protected $_description	= '';
	protected $_createdAt		= '';

	protected $foreign_keys = ['creator_id' => 'User'];

	public function getImage(): string
	{
		$file = '/public/assets/img/post_images/' . $this->getId() . '.png';
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . $file))
			return $file;
		else
			return 'https://bulma.io/images/placeholders/1280x960.png';
	}
}

?>
