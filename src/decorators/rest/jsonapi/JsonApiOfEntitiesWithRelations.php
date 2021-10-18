<?php


namespace vloop\entities\decorators\rest\jsonapi;

use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use vloop\entities\contracts\JsonApiEntities;

class JsonApiOfEntitiesWithRelations implements Entities, JsonApiEntities
{
    private $origin;
    private $needleRelations;

    public function __construct(JsonApiEntities $origin, array $needleRelations) {
        $this->origin = $origin;
        $this->needleRelations = $needleRelations;
    }

    /**
     * @return Entity[] - массив вида [id=>Entity]
     */
    public function list(): array
    {
        $parentList = $this->origin->list();
        if(!array_key_exists('errors', $parentList)){
            return $parentList;
        }
        return $parentList;
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Новая сущность которая только что была создана
     */
    public function add(Form $form): Entity
    {
        $entity = $this->origin->add($form);
        return new JsonApiOfEntityWithRelations(
            $entity
        );
    }

    /**
     * @param int $id
     * @return Entity - конкретная сущность из массив.
     */
    public function entity(int $id): Entity
    {
        // TODO: Implement entity() method.
    }

    /**
     * Реализует паттерн NullObject
     */
    public function isNull(): bool
    {
        // TODO: Implement isNull() method.
    }
}