<?php

$DB_NAME		= 'camagru';
$DB_HOST		= 'mysql';
$DB_DSN			= "mysql:dbname=$DB_NAME;host=$DB_HOST";
$DB_USER		= 'camagru';
$DB_PASSWORD	= 'camagru';
$DB_OPTIONS		= [
					PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
					PDO::ATTR_EMULATE_PREPARES   => false,
				];
?>
