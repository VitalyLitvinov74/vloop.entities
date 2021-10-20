<?php


namespace vloop\entities\decorators\rest\jsonapi;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

class EntitiesWithRelations implements Entities
{
    use Relation;

    private $origin;
    private $needleRelations;

    public function __construct(Entities $origin, array $needleRelations) {
        $this->origin = $origin;
        $this->needleRelations = $needleRelations;
    }

    /**
     * @return Entity[] - массив вида [id=>Entity]
     */
    public function list(): array
    {
        $originList = $this->origin->list();
        if(!array_key_exists('data', $originList)){
            return $originList;
        }
        foreach ($originList['data'] as $item){
            foreach ($this->needleRelations as $needleRelation){
                $this->moveToRelation($item, $needleRelation);
            }
        }
        return $originList;
    }



    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Новая сущность которая только что была создана
     */
    public function add(Form $form): Entity
    {
        $originEntity = $this->origin->add($form);
        return $this->entityWithRelation($originEntity);
    }

    /**
     * @param int $id
     * @return Entity - конкретная сущность из массив.
     */
    public function entity(int $id): Entity
    {
        $originEntity = $this->origin->entity($id);
        return $this->entityWithRelation($originEntity);
    }

    /**
     * Реализует паттерн NullObject
     */
    public function isNull(): bool
    {
        return $this->origin->isNull();
    }

    private function entityWithRelation(Entity $origin){
        return new EntityWithRelations(
            $origin,
            $this->needleRelations
        );
    }
}