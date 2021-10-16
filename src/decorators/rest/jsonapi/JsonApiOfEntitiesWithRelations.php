<?php


namespace vloop\entities\decorators\rest\jsonapi;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

class JsonApiOfEntitiesWithRelations implements Entities
{
    private $origin;
    private $relations;

    /**
     * JsonApiWithRelationships constructor.
     * @param Entities $origin
     * @param Entities[] $relations - связи которые необходимо добавить в вывод
     */
    public function __construct(Entities $origin, array $relations) {
        $this->origin = $origin;
        $this->relations = $relations;
    }

    /**
     * @return Entity[] - массив вида [id=>Entity]
     */
    public function list(): array
    {
        return $this->origin->list();
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
        return $this->origin->entity($id);
    }

    /**
     * Реализует паттерн NullObject
     */
    public function isNull(): bool
    {
        return false;
    }
}