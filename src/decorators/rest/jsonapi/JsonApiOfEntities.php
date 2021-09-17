<?php

namespace vloop\entities\decorators\rest\jsonapi;

use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

class JsonApiOfEntities implements Entities
{
    private $origin;
    private $originType;
    private $needleFields;

    public function __construct(Entities $origin, string $originType, array $needleFields = [])
    {
        $this->origin = $origin;
        $this->originType = $originType;
        $this->needleFields = $needleFields;
    }

    /**
     * @return Entity[] - массив вида [id=>Entity]
     */
    public function list(): array
    {

        return [
            'data' => $this->simpleList()
        ];
    }

    private function simpleList(): array
    {
        static $simple = [];
        static $given = false;
        if ($given) {
            return $simple;
        }
        $originList = $this->origin->list();
        foreach ($originList as $item) {
            $jsonEntity = $this->jsonEntity($item);
            $simple[] = $jsonEntity->printYourself()['data'];
        }
        $given = true;
        return $simple;
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Новая сущность которая только что была создана
     */
    public function add(Form $form): Entity
    {
        return $this->jsonEntity(
            $this->origin->add($form)
        );
    }

    /**
     * @param int $id
     * @return Entity - конкретная сущность из массив.
     */
    public function entity(int $id): Entity
    {
        return $this->jsonEntity(
            $this->origin->entity($id)
        );
    }

    private function jsonEntity(Entity $origin): Entity
    {
        return new JsonApiOfEntity(
            $origin,
            $this->originType,
            $this->needleFields
        );
    }
}