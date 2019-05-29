<?php

namespace App;

class QueryBuilder
{
    private $_select = [];
    private $_where = [];
	private $_from = [];
	private $_limit = null;

	public function select()
	{
        $this->_select = func_get_args();
        return $this;
    }

	public function where()
	{
		foreach(func_get_args() as $arg)
            $this->_where[] = $arg;
        return $this;
    }

	public function from($table, $alias = null)
	{
		if(is_null($alias))
			$this->_from[] = $table;
		else
			$this->_from[] = "$table AS $alias";
        return $this;
	}

	public function limit($limit)
	{
		$this->_limit = $limit;
		return $this;
	}

	public function exec($fetchMode = 2)
	{
		$db = \App\Database::getInstance();

		$query = "$this";
		$values = [];
		foreach ($this->_where as $cond)
		{
			$exp = explode(' ', $cond);
			$values[$exp[0]] = implode(' ', array_slice($exp, 2));
		}

		$stmt = $db->pdo->prepare($query);
		$stmt->execute($values);

		if ($fetchMode == 1)
			return $stmt->fetch();
		else if ($fetchMode == 2)
			return $stmt->fetchAll();
		else
			return $stmt;
	}

	public function fetch()
	{
		return $this->exec(1);
	}

	public function fetchAll()
	{
		return $this->exec(2);
	}

	public function __invoke()
	{
		return $this->_exec();
	}

	public function __toString()
	{
		$where = "";
		foreach ($this->_where as $cond)
		{
			$exp = explode(' ', $cond);
			$where .= " AND $exp[0] $exp[1] :$exp[0]";
		}
		$where = substr($where, 4);
		
		$query  = '';
		$query .= 'SELECT ' . implode(', ', $this->_select);
		$query .= ' FROM ' . implode(', ', $this->_from);
		if ($where != '')
			$query .= ' WHERE ' . $where;
		if (!is_null($this->_limit))
			$query .= ' LIMIT ' . $this->_limit;

		return $query;
    }

}

?>
