<?php


namespace vloop\entities\decorators\rest\jsonapi;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

class JsonApiOfEntity implements Entity
{
    private $origin;
    private $originType;
    private $needleFields;

    public function __construct(Entity $origin, string $originType, array $needleFields = [])
    {
        $this->origin = $origin;
        $this->originType = $originType;
        $this->needleFields = $needleFields;
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
        return [
            'data' => [
                "type" => $this->originType,
                "id" => $this->id(),
                "attributes" => $this->attributes()
            ]
        ];
    }

    private function attributes(): array
    {
        $origArray = $this->origin->printYourself();
        $attributes = [];
        if ($this->needleFields) {
            foreach ($this->needleFields as $needleField) {
                if (array_key_exists($needleField, $origArray)) {
                    $attributes[$needleField] = $origArray[$needleField];
                }
            }
        } else {
            $attributes = $origArray;
        }
        unset($attributes['id']);
        return $attributes;
    }


    /**
     * @param Form $form - форма из которой следует брать провалидированные значения
     * @return Entity - возвращает себя же.
     */
    public function changeLineData(Form $form): Entity
    {
        $origin = $this->origin->changeLineData($form);
        return new self(
            $origin,
            $this->originType,
            $this->needleFields
        );
    }

    /**
     * удаляет себя насовсем.
     */
    public function remove(): void
    {
        $this->origin->remove();
    }
}