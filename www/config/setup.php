<?php

require_once 'database.php';

//$DB_OPTIONS = [
//  PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
//  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
//  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
//];

try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
} catch (PDOException $e) {
	die('Échec lors de la connexion: ' . $e->getMessage() . PHP_EOL);
}

//$stmt = $db->prepare('SELECT * FROM test WHERE id = :id;');
//$stmt->execute([':id' => 1]);
//$stmt = $db->prepare('SELECT * FROM test WHERE id = :id;')->execute([':id' => 1]);
//$rows = $stmt->fetchAll();
//foreach ($rows as $row)
//	echo '<pre>', print_r($row), '</pre>';

//$db->query('DROP TABLE IF EXISTS `users`;');
//$db->query(<<<SQL
//	CREATE TABLE `users` (
//		`id` INT NOT NULL AUTO_INCREMENT,
//		`username` VARCHAR(32) NOT NULL,
//		`first_name` VARCHAR(255) NOT NULL,
//		`last_name` VARCHAR(255) NOT NULL,
//		`mail` VARCHAR(255) NOT NULL,
//		`passhash` TEXT NOT NULL,
//		`mail_token` TEXT NOT NULL,
//		PRIMARY KEY (`id`))
//	ENGINE = InnoDB;
//SQL
//);
//
//$db->query('DROP TABLE IF EXISTS `photos`;');
//$db->query(<<<SQL
//	CREATE TABLE `photos` (
//		`id` INT NOT NULL AUTO_INCREMENT,
//		`title` VARCHAR(255) NOT NULL,
//		`likes_count` INT NOT NULL, `comments_count` INT NOT NULL,
//		`path` TEXT NOT NULL,
//		`creator_id` INT NOT NULL,
//		PRIMARY KEY (`id`))
//	ENGINE = InnoDB;
//SQL
//);

$sql = file_get_contents('docker.sql');
$qr = $db->exec($sql);

echo 'Database is now ready !', PHP_EOL;

?>
