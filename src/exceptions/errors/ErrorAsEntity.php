<?php


namespace vloop\entities\exceptions\errors;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

/**
 * Class ExceptionAsError - исключение в виде сущности. используется при обработки ошибок.
 * @package vloop\entities\exceprions\errors
 */
class ErrorAsEntity implements Entity
{
    private $title;
    private $message;

    public function __construct(string $title, string $message) {
        $this->title = $title;
        $this->message = $message;
    }


    public function id(): int
    {
        return 0;
    }

    /**
     * @return array - печатает себя в виде массива
     */
    public function printYourself(): array
    {
        return [
            'title'=>$this->title,
            'message'=>$this->message
        ];
    }

    /**
     * @param Form $form - форма из которой следует брать провалидированные значения
     * @return Entity - возвращает себя же.
     */
    public function changeLineData(Form $form): Entity
    {
        return $this;
    }

    /**
     * удаляет себя насовсем.
     */
    public function remove(): void
    {
        //not action
    }
}