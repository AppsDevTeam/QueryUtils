<?php

namespace ADT\QueryUtils\Query;

use Doctrine\ORM;


/**
 */
class BaseQuery {

	use \Nette\SmartObject;

	const METHOD_AND = 'and';
	const METHOD_OR = 'or';

	/**
	 * Generated Doctrine Expr object.
	 * @var ORM\Query\Expr\Composite
	 */
	protected $expr;

	/**
	 * @return ORM\Query\Expr\Composite
	 */
	public function getExpr()
	{
		return $this->expr;
	}

	/**
	 * Generated parameters.
	 * @var array Index is parameter name.
	 */
	protected $parameters;

	/**
	 * @return array
	 */
	public function getParameters()
	{
		return $this->parameters;
	}

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
	 * @param ORM\QueryBuilder|ORM\Query\Expr\Base $bindTo Query builder or expr to use expr on.
	 * @param string $method Logic method to use when binding to queryBuilder.
	 */
	public function bindExprTo($bindTo, $method = self::METHOD_AND) {
		if ($bindTo instanceof ORM\Query\Expr\Base) {
			$bindTo->add($this->expr);

		} else {
			// QueryBuilder
			$bindTo->{$method . 'Where'}($this->expr);
		}
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
