<?php
use \App\Helpers;
?>
<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Camagru</title>
	<link rel="stylesheet" href="<?= Helpers::css('style'); ?>">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />
    <link rel="icon" href="<?= Helpers::image('favicon.ico'); ?>" />
  </head>

	<body class="has-navbar-fixed-top">
		<?php if (Helpers::flash()): ?>
		  <div class="container">
		  	<div class="notification is-<?= Helpers::flash('type') ?>">
		  		<button class="delete"></button>
						<?= Helpers::flash('message') ?>	
		  	</div>
		  </div>
		<?php endif; Helpers::clear_flash(); ?>
	
