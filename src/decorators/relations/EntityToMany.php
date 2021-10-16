<?php


namespace vloop\entities\decorators\relations;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

class EntityToMany implements Entity
{
    private $parent;
    private $kids;

    public function __construct(Entity $parent, Entities $kids) {
        $this->kids = $kids;
        $this->parent = $parent;
    }

    public function id(): int
    {
        return $this->parent->id();
    }

    /**
     * @return array - печатает себя в виде массива
     */
    public function printYourself(): array
    {
        $parent = $this->parent->printYourself();
        foreach ($this->kids as $kid) {

        }
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

    /**
     * Реализаует паттерн NullObject
     */
    public function isNull(): bool
    {
        // TODO: Implement isNull() method.
    }
}