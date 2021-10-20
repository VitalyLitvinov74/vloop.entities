<?php


namespace vloop\entities\decorators\rest\jsonapi;


use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use vloop\entities\contracts\JsonApiEntities;
use vloop\entities\contracts\JsonApiEntity;
use vloop\entities\contracts\JsonApiTypeOfEntity;

class JsonApiOfEntity implements Entity
{

    use JsonDataTrait;

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
        $origin = $this->origin;
        if($origin->isNull()){
            return [
                'errors'=> $origin->printYourself()
            ];
        }

        return [
            'data'=> $this->jsonDataFromArray(
                $this->originType,
                $origin->printYourself(),
                $this->needleFields
            )
        ];
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

    /**
     * Реализаует паттерн NullObject
     */
    public function isNull(): bool
    {
        return $this->origin->isNull();
    }
}