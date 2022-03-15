<?php


namespace vloop\entities\yii2\criteria;


use yii\db\ActiveQuery;
use yii\db\Query;

class InTable implements IImprovedQuery
{
    private $classnameOfTable;

    /**
     * DefaultConditionInTable constructor.
     * @param string $tableName например TAbleAppeals::class
     */
    public function __construct(string $tableName)
    {
        $this->classnameOfTable = $tableName;
    }

    /**
     * @return Query - возвращает подготовленный/изменнный критерий поиска
     *
     */
    public function queryOfSearch(): Query
    {
        return new ActiveQuery($this->classnameOfTable);
    }
}