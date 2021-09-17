<?php


namespace vloop\entities\decorators;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use vloop\entities\exceptions\NotFoundEntity;

/**
 * список сущностей со сброшенным id. в основном используется когда список содержит 1 элемент
 * Class ResetKeysOnListEntities
 * @package vloop\entities\decorators
 */
class ResetKeysOnListEntities implements Entities
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
        $list = $this->origin->list();
        return array_values($list);
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
     * @throws NotFoundEntity
     */
    public function entity(int $id): Entity
    {
        $list =$this->list();
        if(key_exists($id, $list)){
            return $list[$id];
        }
        throw new NotFoundEntity("Сущность не была найдена.");
    }
}