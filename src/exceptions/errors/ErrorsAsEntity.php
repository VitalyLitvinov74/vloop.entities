<?php


namespace vloop\entities\exceptions\errors;


use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

/**
 * Class NestedArrayAsEntity
 * @package vloop\entities\exceprions\errors
 */
class ErrorsAsEntity implements Entity
{
    private $allErrors;

    /**
     * NestedArrayAsEntity constructor.
     * @param array $allErrors - массив в виде:
     *  [
     *      'description'=>[
     *          'description must be string',
     *          'descritpion not validated',
     *      ],
     *      'title'=>[
     *          'error1',
     *          'error2'
     *      ]
     *  ]
     */
    public function __construct(array $allErrors) {
        $this->allErrors = $allErrors;
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
        $answer =  [];
        foreach ($this->allErrors as $attribute=>$errors){
            foreach ($errors as $concreteErrorDescription){
                $answer[] = [
                    "title"=>$attribute,
                    'description'=>$concreteErrorDescription
                ];
            }
        }
        return $answer;
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
        // not action
    }
}