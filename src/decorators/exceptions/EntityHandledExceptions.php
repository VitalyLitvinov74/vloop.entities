<?php


namespace vloop\entities\decorators\exceptions;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

/**
 * Сущность, с обработанными ошибками.
 * Class EntityHandledExceptions
 * @package vloop\entities\decorators\exceptions
 */
class EntityHandledExceptions implements Entity
{

    private $origin;

    function __construct(Entity $origin)
    {
        $this->origin = $origin;
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
        return $this->origin->printYourself();
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
}