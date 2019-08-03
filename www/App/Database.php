<?php
namespace App;

class Database
{
	private static $_instance = null;

	public $pdo = null;

	private function __construct()
	{
		include '../config/database.php';
		
		try {
			$this->pdo = new \PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
		} catch (\PDOException $err) {
			throw new \PDOException($err->getMessage(), (int)$err->getCode());
		}
	}

	public static function getInstance(): Database
	{
		if (is_null(self::$_instance))
			self::$_instance = new Database();
		return self::$_instance;
	}

	public function query($query, array $values, $fetch = 2)
	{
		$stmt = $this->pdo->prepare($query);
		$stmt->execute($values);
		if ($fetch == 1) return $stmt->fetch();
		else if ($fetch == 2) return $stmt->fetchAll();
		else return $stmt;
	}
}

?>
