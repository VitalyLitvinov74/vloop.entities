<?php


namespace vloop\entities\decorators;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

/**
 * сущности которые закешированы в оп  с помощью возможностей языка
 * Class CachedEntities
 * @package vloop\entities\decorators
 */
class CachedEntities implements Entities
{
    private $origin;

    public function __construct(Entities $origin) {
        $this->origin = $origin;
    }

    /**
     * @return Entity[] - массив вида [id=>Entity]
     */
    public function list(): array
    {
        static $list = [];
        static $searched = false;
        if($searched){
            return $list;
        }
        $list = $this->origin->list();
        $searched = true;
        return $list;
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Новая сущность которая только что была создана
     */
    public function add(Form $form): Entity
    {
        return $this->origin->add($form);
    }

    /**
     * @param int $id
     * @return Entity - конкретная сущность из массив.
     */
    public function entity(int $id): Entity
    {
        return $this->list()[$id];
    }

    /**
     * Реализует паттерн NullObject
     */
    public function isNull(): bool
    {
        return $this->origin->isNull();
    }
}