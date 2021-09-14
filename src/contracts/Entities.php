<?php


namespace vloop\entities\contracts;


interface Entities
{
    /**
     * @return Entity[] - массив вида [id=>Entity]
     */
    public function list(): array;

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Новая сущность которая только что была создана
     */
    public function add(Form $form): Entity;

    /**
     * @param int $id
     * @return Entity - конкретная сущность из массив.
     */
    public function entity(int $id): Entity;
}