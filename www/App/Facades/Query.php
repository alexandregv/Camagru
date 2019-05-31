<?php

namespace App\Facades;
use \App\QueryBuilder;

class Query
{
	public static function __callStatic(string $method, array $arguments)
	{
        $query = new QueryBuilder();
        return call_user_func_array([$query, $method], $arguments);
    }
}

?>
