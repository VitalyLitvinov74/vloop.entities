<?php


namespace vloop\entities\standarts\json\decorators\meta;


use vloop\entities\yii2\queries\IImprovedQuery;

class WithTotalCountMetaPage implements IMeta
{
    private $condition;

    /**
     * TotalCountMeta constructor.
     * @param IImprovedQuery $condition - условие поиска из которого следует вытащить всё кол-во записей
     */
    public function __construct(IImprovedQuery $condition)
    {
        $this->condition = $condition;
    }

    public function value(): string
    {
        return $this->condition->queryOfSearch()->count();
    }

    /**
     * @return array - печатает себя в виде массива.
     * Если в объекте есть вложенные объекты и коллекции - преобразует их в массив.
     */
    public function printYourSelf(): array
    {
        return [
            'totalCount' => $this->value()
        ];
    }
}