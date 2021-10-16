<?php


namespace vloop\entities\decorators\relations;


use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

class EntityToOne implements Entity
{
    private $kid;
    private $parent;
    private $relationName;

    /**
     * EntityToOne constructor.
     * @param Entity $parent
     * @param Entity $kid
     * @param string $relationName - имя связи которое будет возвращено
     */
    public function __construct(Entity $parent, Entity $kid, string $relationName) {
        $this->kid = $kid;
        $this->parent = $parent;
        $this->relationName = $relationName;
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
        $parent['relationships'][$this->relationName] = $this->kid->printYourself();
        return $parent;
    }

    /**
     * @param Form $form - форма из которой следует брать провалидированные значения
     * @return Entity - возвращает себя же.
     */
    public function changeLineData(Form $form): Entity
    {
        $this->parent->changeLineData($form);
        return $this;
    }

    /**
     * удаляет себя насовсем.
     */
    public function remove(): void
    {
        $this->parent->remove();
    }

    /**
     * Реализаует паттерн NullObject
     */
    public function isNull(): bool
    {
        return false;
    }
}