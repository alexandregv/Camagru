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

	public function getImage()
	{
		//TODO: get corresponding file in /public/assets/img/post_images/
		return 'https://bulma.io/images/placeholders/128x128.png';
	}
}

?>
