<?php


namespace vloop\entities\decorators\rest\jsonapi;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

class EntityWithRelations implements Entity
{
    use Relation;

    private $origin;
    private $needleRelations;

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
        $originData = $this->origin->printYourself();
        if(!array_key_exists('data', $originData)
            and !array_key_exists('attributes', $originData['data'])){
            return $originData;
        }
        $data = $originData['data'];
        foreach ($this->needleRelations as $needleRelation){
            $this->moveToRelation($data, $needleRelation);
        }
        return [
            'data'=>$data
        ];
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