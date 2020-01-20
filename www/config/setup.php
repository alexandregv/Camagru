<?php

require_once 'database.php';

try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
} catch (PDOException $e) {
	if ($e->getCode() == 1049) {
		try {
			$db = new PDO("mysql:host=$DB_HOST", $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
		} catch (PDOException $e) {
			die('Échec lors de la connexion: ' . $e->getMessage() . PHP_EOL);
		}
	}
	else die('Échec lors de la connexion: ' . $e->getMessage() . PHP_EOL);
}

$sql = file_get_contents('setup.sql');
$qr = $db->exec($sql);

echo 'Database is now ready !', PHP_EOL;

?>
