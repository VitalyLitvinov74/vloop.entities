<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 19.09.2021
 * Time: 13:18
 */

namespace vloop\entities\decorators\rest\jsonapi\decorators;


use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

class JsonApiOfEntityWithErrors implements Entity
{
    private $origin;

    function __construct(Entity $origin)
    {
        $this->origin = $origin;
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
            'errors'=>$this->origin->printYourself()
        ];
    }

    /**
     * @param Form $form - форма из которой следует брать провалидированные значения
     * @return Entity - возвращает себя же.
     */
    public function changeLineData(Form $form): Entity
    {
        $this->origin->changeLineData($form);
        return $this;
    }

    /**
     * удаляет себя насовсем.
     */
    public function remove(): void
    {
        $this->origin->remove();
    }
}