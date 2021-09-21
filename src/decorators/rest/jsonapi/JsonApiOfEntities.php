<?php


namespace vloop\entities\decorators\rest\jsonapi;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use yii\helpers\VarDumper;

class JsonApiOfEntities implements Entities
{
    private $origin;
    private $originType;
    private $needleFields;

    public function __construct(Entities $origin, string $originType, array $needleFields = [])
    {
        $this->origin = $origin;
        $this->originType = $originType;
        $this->needleFields = $needleFields;
    }

    /**
     * @return Entity[] - массив вида [id=>Entity]
     */
    public function list(): array
    {
        static $simple = [];
        static $given = false;
        if ($given) {
            return $simple;
        }
        $originList = $this->origin->list(); //может быть обычным массивом с ошибкой, или массивом сущностей.
        if (is_object($originList[0])) {
            $simple = $this->data($originList);
        } else {
            $simple = $this->errors($originList);
        }
        return $simple;
    }

    private function errors($originList)
    {
        return [
            'errors' => $originList
        ];
    }

    private function data($originList)
    {
        $simple = [];
        foreach ($originList as $item) {
            $jsonEntity = $this->jsonEntity($item);
            $simple[] = $jsonEntity->printYourself()['data'];
        }
        return [
            'data' => $simple
        ];
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Новая сущность которая только что была создана
     */
    public function add(Form $form): Entity
    {
        return $this->jsonEntity(
            $this->origin->add($form)
        );
    }

    /**
     * @param int $id
     * @return Entity - конкретная сущность из массив.
     */
    public function entity(int $id): Entity
    {
        return $this->jsonEntity(
            $this->origin->entity($id)
        );
    }

    private function jsonEntity(Entity $origin): Entity
    {
        return new JsonApiOfEntity(
            $origin,
            $this->originType,
            $this->needleFields
        );
    }

    /**
     * Реализует паттерн NullObject
     */
    public function isNull(): bool
    {
        return false;
    }
}