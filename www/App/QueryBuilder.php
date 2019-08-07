<?php

namespace App;
use \App\Database;

class QueryBuilder
{
    private $_select	= [];
    private $_update	= '';
    private $_set		= [];
    private $_where		= [];
	private $_from		= [];
	private $_orderBy	= '';
	private $_limit		= null;
	private $_offset	= null;

	public function select(): QueryBuilder
	{
        $this->_select = func_get_args();
        return $this;
    }

	public function update(string $table): QueryBuilder
	{
        $this->_update = $table;
        return $this;
    }

	public function set(array $attributes): QueryBuilder
	{
        $this->_set = $attributes;
        return $this;
    }

	public function where(array $attrs): QueryBuilder
	{
		foreach($attrs as $attr => $val)
            $this->_where[$attr] = $val;
        return $this;
    }

	public function from(string $table, string $alias = null): QueryBuilder
	{
		if(is_null($alias))
			$this->_from[] = $table;
		else
			$this->_from[] = "$table AS $alias";
        return $this;
	}

	public function orderBy(string $table, string $order): QueryBuilder
	{
		$order = strtoupper($order);
		$this->_orderBy = "$table $order";
		return $this;
	}

	public function limit(int $limit): QueryBuilder
	{
		$this->_limit = $limit;
		return $this;
	}

	public function offset(int $offset): QueryBuilder
	{
		$this->_offset = $offset;
		return $this;
	}

	public function exec(int $fetchMode = 2)
	{
		$db = Database::getInstance();

		$query = "$this";
		$values = [];

		if (!empty($this->_set))
			$values = array_merge($this->_set, $values);

		$values = array_merge($this->_where, $values);

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

	public function __invoke(int $fetchMode = 2)
	{
		return $this->_exec($fetchMode);
	}

	public function __toString(): string
	{
		$where = "";
		foreach ($this->_where as $attr => $val)
			$where .= " AND $attr = :$attr";
		$where = substr($where, 4);
		
		$query  = '';
		if (!empty($this->_select))
			$query .= 'SELECT ' . implode(', ', $this->_select);
		if ($this->_update != '')
			$query .= 'UPDATE ' . $this->_update;
		if (!empty($this->_set))
		{
			$str = '';
			$shift = $this->array_shift_assoc_kv($this->_set);
			$str .= key($shift) . ' = :' . key($shift);
			foreach ($this->_set as $attr => $val)
				$str .= ", $attr = :$attr";
			$query .= ' SET ' . $str;
			$this->_set[key($shift)] = $shift[key($shift)];
		}
		if (!empty($this->_from))
			$query .= ' FROM ' . implode(', ', $this->_from);
		if ($where != '')
			$query .= ' WHERE ' . $where;
		if ($this->_orderBy != '')
			$query .= ' ORDER BY ' . $this->_orderBy;
		if (!is_null($this->_limit))
			$query .= ' LIMIT ' . $this->_limit;
		if (!is_null($this->_offset))
			$query .= ' OFFSET ' . $this->_offset;
		return $query;
	}

	private function array_shift_assoc_kv( &$arr ){
		$val = reset( $arr );
		$key = key( $arr );
		$ret = array( $key => $val );
		unset( $arr[ $key ] );
		return $ret;
	}

}

?>
