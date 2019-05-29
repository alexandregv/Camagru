<?php

namespace App\Facades;

class Query
{
	public static function __callStatic($method, $arguments)
	{
        $query = new \App\QueryBuilder();
        return call_user_func_array([$query, $method], $arguments);
    }
}

?>
