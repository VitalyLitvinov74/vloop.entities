<?php


namespace vloop\entities\yii2\queries;


use yii\db\Query;

interface IImprovedQuery
{
    /**
     * @return Query - возвращает улучшенный запрос, который можно конструировать из объектов.
     */
    public function queryOfSearch(): Query;
}