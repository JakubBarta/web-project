<?php
/**
 * Author: Jakub Barta <jakub.barta@gmail.com>
 * Date: 20.09.15
 * Time: 14:58
 */

namespace App\Model\Query;


use Kdyby;
use Kdyby\Doctrine\QueryObject;
use Nette\Utils\Validators;

abstract class BaseQuery extends QueryObject
{
    /** @var \Closure[] */
    private $selects = [];

    /** @var \Closure[] */
    private $filters = [];

    private $orderings = [];

    /**
     * @param string $column
     * @param string $direction asc or desc
     */
    protected function addOrdering($column, $direction = 'asc')
    {
        $this->orderings[] = [$column, $direction];
    }

    /**
     * @param callable $cb
     * @throws \Nette\Utils\AssertionException
     */
    protected function addFilter($cb)
    {
        Validators::assert($cb, 'callable');

        $this->filters[] = $cb;
    }

    /**
     * @param callable $cb
     * @throws \Nette\Utils\AssertionException
     */
    protected function addSelect($cb)
    {
        Validators::assert($cb, 'callable');

        $this->selects[] = $cb;
    }

    /**
     * @param \Kdyby\Persistence\Queryable $repository
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    protected function doCreateQuery(Kdyby\Persistence\Queryable $repository)
    {
        $qb = $this->init($repository);

        foreach ($this->selects as $select) {
            call_user_func($select, $qb);
        }

        foreach ($this->filters as $filter) {
            call_user_func($filter, $qb);
        }

        foreach ($this->orderings as $ordering) {
            $qb->addOrderBy($ordering[0], $ordering[1]);
        }

        return $qb;
    }

    /**
     * @param Kdyby\Persistence\Queryable $repository
     * @return Kdyby\Doctrine\QueryBuilder
     */
    abstract protected function init(Kdyby\Persistence\Queryable $repository);

}
