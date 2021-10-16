<?php


namespace vloop\entities\decorators;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

class EntitiesWithRelations implements Entities
{
    public function __construct(Entities $origin, Entities $entitiesForRelation, $) {

    }

    /**
     * @return Entity[] - массив вида [id=>Entity]
     */
    public function list(): array
    {
        // TODO: Implement list() method.
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Новая сущность которая только что была создана
     */
    public function add(Form $form): Entity
    {
        // TODO: Implement add() method.
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