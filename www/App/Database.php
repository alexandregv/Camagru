<?php

namespace App;

class Database
{
	private static $_instance = null;

	private $_host = 'mysql';
	private $_base = 'docker';
	private $_user = 'docker';
	private $_pass = 'docker';

	public $pdo = null;

	private function __construct()
	{
		$options = [
			\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
			\PDO::ATTR_EMULATE_PREPARES   => false,
		];

		$dsn = "mysql:host=$this->_host;dbname=$this->_base";

		try {
			$this->pdo = new \PDO($dsn, $this->_user, $this->_pass, $options);
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
