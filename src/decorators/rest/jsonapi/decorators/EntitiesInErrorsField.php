<?php


namespace vloop\entities\decorators\rest\jsonapi\decorators;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

class EntitiesInErrorsField implements Entities
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
        return [
            'errors'=>$this->origin->list()
        ];
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Новая сущность которая только что была создана
     */
    public function add(Form $form): Entity
    {
        return new EntityInErrorsField(
            $this->origin->add($form)
        );
    }

    /**
     * @param int $id
     * @return Entity - конкретная сущность из массив.
     */
    public function entity(int $id): Entity
    {
        return new EntityInErrorsField(
            $this->origin->entity($id)
        );
    }
}