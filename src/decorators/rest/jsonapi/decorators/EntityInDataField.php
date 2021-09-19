<?php


namespace vloop\entities\decorators\rest\jsonapi;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

class EntityInDataField implements Entity
{

    public function id(): int
    {
        // TODO: Implement id() method.
    }

    /**
     * @return array - печатает себя в виде массива
     */
    public function printYourself(): array
    {
        // TODO: Implement printYourself() method.
    }

    /**
     * @param Form $form - форма из которой следует брать провалидированные значения
     * @return Entity - возвращает себя же.
     */
    public function changeLineData(Form $form): Entity
    {
        // TODO: Implement changeLineData() method.
    }

    /**
     * удаляет себя насовсем.
     */
    public function remove(): void
    {
        // TODO: Implement remove() method.
    }
}