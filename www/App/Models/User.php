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

}

?>
