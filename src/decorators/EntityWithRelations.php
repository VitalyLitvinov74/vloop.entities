<?php


namespace vloop\entities\decorators;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

class EntityWithRelations implements Entity
{
    private $origin;
    private $needleRelations;

    /**
     * @param Entity $origin
     * @param array $needleRelations - поля которые которые превратятся в связи (если они есть) 
     */
    public function __construct(Entity $origin, array $needleRelations) {
        $this->origin = $origin;
        $this->needleRelations = $needleRelations;
    }

    public function id(): int
    {
        return $this->origin->id();
    }

    /**
     * @return array - печатает себя в виде массива
     */
    public function printYourself(): array
    {
        $originFields = $this->origin->printYourself();
        foreach ($this->needleRelations as $needleRelation) {
            if(array_key_exists($needleRelation, $originFields)){
                $originFields['relationships'][] = $originFields[$needleRelation];
                unset($originFields[$needleRelation]);
            }
        }
        return $originFields;
    }

    /**
     * @param Form $form - форма из которой следует брать провалидированные значения
     * @return Entity - возвращает себя же.
     */
    public function changeLineData(Form $form): Entity
    {
        $this->origin->changeLineData($form);
        return $this;
    }

    /**
     * удаляет себя насовсем.
     */
    public function remove(): void
    {
        $this->origin->remove();
    }

    /**
     * Реализаует паттерн NullObject
     */
    public function isNull(): bool
    {
        return $this->origin->isNull();
    }
}