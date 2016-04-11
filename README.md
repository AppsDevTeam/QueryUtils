#  Query Utils

Set of Doctrine ORM query helpers.

## Prepared Queries

All predefined queries share common ancestor: `Query\BaseQuery`.
This class exposes these public methods:

1. `bindExprTo($qb)` - binds generated expression to your QueryBuilder,
2. `bindParametersTo($qb)` - binds generated parameters to your QueryBuilder,
3. `bindTo($qb)` - binds expression and parameters to your QueryBuilder.

Also, `bindExprTo` and `bindTo` have second, optional parameter `$method` which defaults to `and`.
This represents method used for binding.

1. if `and` is passed, `$qb->andWhere(...)` is used,
1. if `or` is passed, `$qb->orWhere(...)` is used.

### Full-text Query

For string `$q` to lookup on columns `client.firstName` and `client.lastName` use following:

long form:
```php
$helper = new \ADT\QueryUtils\Query\FullTextQuery($q, [
    'client.firstName', 'client.lastName'
]);
 
$helper->bindTo($queryBuilder);
```

or short form:
```php
\ADT\QueryUtils\Query\FullTextQuery::create($q, [
    'client.firstName', 'client.lastName'
])->bindTo($queryBuilder);
```
