<?php


namespace vloop\entities\yii2\queries\decorators;


use vloop\entities\yii2\queries\IImprovedQuery;
use yii\data\Sort;
use yii\db\Query;

class WithSort implements IImprovedQuery
{

    private $originCondition;
    private $sort;

    public function __construct(IImprovedQuery $condition, array $attributesForSorting)
    {
        $this->sort = new Sort([
            'attributes' => $attributesForSorting,
            'enableMultiSort' => true
        ]);
        $this->originCondition = clone $condition;
    }

    public function queryOfSearch(): Query
    {
        $query = clone $this->originCondition
            ->queryOfSearch();
        return $query
            ->addOrderBy($this->sort->orders);
    }
}