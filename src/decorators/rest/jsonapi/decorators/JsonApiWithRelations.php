<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 19.09.2021
 * Time: 0:33
 */

namespace vloop\entities\decorators\rest\jsonapi\decorators;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use vloop\entities\decorators\rest\jsonapi\JsonApiOfEntities;
use vloop\entities\decorators\rest\jsonapi\JsonApiOfEntity;
//TODO без входных данныех нельзя разрабатывать данный класс. нужно к нему вернуться
//TODO когд будет реализован основной функционал добавления данных.
class JsonApiWithRelations implements Entities
{
    private $origin;
    private $relations;

    /**
     * JsonApiEntitiesWithRelations constructor.
     * @param Entities $origin
     * @param JsonApiOfEntities[] $relations
     */
    public function __construct(Entities $origin, array $relations)
    {
        $this->relations = $relations;
        $this->origin = $origin;
    }

    /**
     * @return Entity[] - массив вида [id=>Entity]
     */
    public function list(): array
    {
        $origList = $this->list()['data'];
        $list = [];
        foreach ($origList as $origEntity) {
            $list[] = $origEntity
        }
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
        $origin = $this->origin->entity('int');
        $origin['data']['relations'] = ...
    }

    /**
     * @return Entity[]
     */
    private function relations(): array
    {
        $relationsList = [];
        foreach ($this->relations as $relationEntity) {
            $entity = $relationEntity->entity();
        }
    }
}