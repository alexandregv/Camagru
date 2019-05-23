<?php

namespace App\Models;

class Comment extends Model
{
	protected $_id			= 00;
	protected $_post_id		= 00;
	protected $_author_id	= 00;
	protected $_content		= '';
	protected $_createdAt	= '';

	protected $foreign_keys = ['post_id' => 'Post', 'author_id' => 'User'];
}

?>
