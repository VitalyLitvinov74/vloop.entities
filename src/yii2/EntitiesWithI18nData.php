<?php


namespace vloop\entities\yii2;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

/**
 * см. описание, EntityWithI18nData
 * Class EntitiesWithI18NData
 * @package vloop\entities\yii2
 */
class EntitiesWithI18NData implements Entities
{
    private $origin;

    public function __construct(Entities $origin) {
        $this->origin = $origin;
    }

    /**
     * @inheritDoc
     */
    public function list(): array
    {
        $origList = $this->origin->list();
        $newList = [];
        foreach ($origList as $key=>$entity){
            $newList[$key] = new EntityWithI18nData($entity);
        }
        return $newList;
    }

    /**
     * @inheritDoc
     */
    public function add(Form $form): Entity
    {
        $entity = $this->origin->add($form);
        return new EntityWithI18nData($entity);
    }

    /**
     * @inheritDoc
     */
    public function entity(int $id): Entity
    {
        return $this->list()[$id];
    }

    /**
     * @inheritDoc
     */
    public function isNull(): bool
    {
        return $this->isNull();
    }
}