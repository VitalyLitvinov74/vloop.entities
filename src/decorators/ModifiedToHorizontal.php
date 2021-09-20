<?php


namespace vloop\entities\decorators;


use vloop\entities\contracts\Diff;
use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

/**
 * пока рано говорить для преобразования декораторов в горизонтальный вид.
 * Class ModifiedToHorizontal
 * @package vloop\entities\decorators
 */
class ModifiedToHorizontal implements Entities
{
    private $diff;
    private $origin;

    public function __construct(Entities $origin, Diff $differentObjects) {
        $this->origin = $origin;
        $this->diff = $differentObjects;
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
}