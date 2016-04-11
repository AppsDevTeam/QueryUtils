<?php

namespace ADT\QueryUtils\Query;

use Doctrine\ORM;


class FullTextQuery extends BaseQuery {

	const DEFAULT_PREFIX = 'fullText';

	/**
	 * FullTextQuery constructor.
	 * @param string $query Query to search.
	 * @param string[] $fields Array of full path fields. Eg. ['client.firstName', 'client.lastName']
	 * @param string $parameterPrefix Choose different prefix for multiple uses on one Doctrine QueryBuilder.
	 */
	public function __construct($query, $fields, $parameterPrefix = self::DEFAULT_PREFIX) {
		$words = preg_split('~\s+~', $query);

		$and = new ORM\Query\Expr\Andx();
		$parameters = [ ];

		foreach ($words as $i => $word) {
			$paramName = "{$parameterPrefix}_word{$i}_like";
			$or = new ORM\Query\Expr\Orx();

			foreach ($fields as $field) {
				$or->add("{$field} LIKE :$paramName");
			}

			$and->add($or);
			$parameters[$paramName] = "%$word%";
		}

		parent::__construct($and, $parameters);
	}

	/**
	 * @see FullTextQuery::__construct
	 * @param string $query
	 * @param string[] $fields
	 * @param string $parameterPrefix
	 * @return static
	 */
	public static function create($query, $fields, $parameterPrefix = self::DEFAULT_PREFIX) {
		return new static($query, $fields, $parameterPrefix);
	}

}