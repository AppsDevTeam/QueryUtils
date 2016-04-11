<?php

namespace ADT\QueryUtils\Query;

use Doctrine\ORM;


/**
 * @method ORM\Query\Expr\Composite getExpr() Generated Doctrine ORM Expr object.
 * @method array getParameters() Generated parameters. Index is parameter name.
 */
class BaseQuery extends \Nette\Object {

	const METHOD_AND = 'and';
	const METHOD_OR = 'or';

	/**
	 * Generated Doctrine Expr object.
	 * @var ORM\Query\Expr\Composite
	 */
	protected $expr;

	/**
	 * Generated parameters.
	 * @var array Index is parameter name.
	 */
	protected $parameters;

	/**
	 * BaseQuery constructor.
	 * @param ORM\Query\Expr\Composite $expr
	 * @param array $parameters
	 */
	public function __construct(ORM\Query\Expr\Composite $expr, $parameters = [ ]) {
		$this->expr = $expr;
		$this->parameters = $parameters;
	}

	/**
	 * Use expr on given Doctrine QueryBuilder.
	 * @param ORM\QueryBuilder $queryBuilder Query builder to use expr on.
	 * @param string $method Logic method to use when binding.
	 */
	public function bindExprTo(ORM\QueryBuilder $queryBuilder, $method = self::METHOD_AND) {
		$queryBuilder->{$method . 'Where'}($this->expr);
	}

	/**
	 * Bind parameters to given Doctrine QueryBuilder.
	 * @param ORM\QueryBuilder $queryBuilder Query builder to bind parameters to.
	 */
	public function bindParametersTo(ORM\QueryBuilder $queryBuilder) {
		foreach ($this->parameters as $name => $value) {
			$queryBuilder->setParameter($name, $value);
		}
	}

	/**
	 * Use expr on and bind parameter to given Doctrine QueryBuilder.
	 * @param ORM\QueryBuilder $queryBuilder QueryBuilder to use expr on and bind parameters to.
	 * @param string $method Logic method to use when binding expr.
	 */
	public function bindTo(ORM\QueryBuilder $queryBuilder, $method = self::METHOD_AND) {
		$this->bindExprTo($queryBuilder, $method);
		$this->bindParametersTo($queryBuilder);
	}
}