<?php

namespace vloop\entities\decorators\rest\jsonapi;

use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

class EntitiesInDataField implements Entities
{

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
}