<?php


namespace vloop\entities\yii2\queries\decorators;

use vloop\entities\contracts\IForm;
use vloop\entities\exceptions\NotValidatedFields;
use vloop\entities\yii2\forms\PaginationForm;
use vloop\entities\yii2\queries\IImprovedQuery;
use yii\db\Query;

/**
 * Class WithPagination - work as cursor pagination
 * @package vloop\entities\yii2\queries
 */
class WithPagination implements IImprovedQuery
{

    private $origin;
    private $paginationForm;

    /**
     * WithCursorPagination constructor.
     * @param IImprovedQuery          $condition
     * @param IForm|PaginationForm $paginationForm
     */
    public function __construct(IImprovedQuery $condition, IForm $paginationForm)
    {
        $this->origin = clone $condition;
        $this->paginationForm = $paginationForm;
    }

    /**
     * @return Query
     * @throws NotValidatedFields
     */
    public function queryOfSearch(): Query
    {
        $fields = $this->paginationForm->validatedFields();
        $query = clone($this->origin->queryOfSearch());
        $query
            ->limit($fields['size'])
            ->offset($fields['after']);
        return $query;
    }
}