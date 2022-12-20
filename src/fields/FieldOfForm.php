<?php


namespace vloop\entities\fields;

use vloop\entities\contracts\IField;
use vloop\entities\contracts\IForm;
use vloop\entities\exceptions\NotValidatedFields;

class FieldOfForm implements IField
{
    private $form;
    private $needleField;
    private $_value;

    public function __construct(IForm $form, string $needleField)
    {
        $this->form = $form;
        $this->needleField = $needleField;
    }

    public function asInt(): int
    {
        return $this->value()->asInt();
    }

    public function asFloat(): float
    {
        return $this->value()->asFloat();
    }

    public function asBool(): bool
    {
        return $this->value()->asBool();
    }

    public function asString(): string
    {
        return $this->value()->asString();
    }

    /**
     * @return mixed
     * @throws NotValidatedFields
     */
    private function value(){
        if(!is_null($this->_value)){
            return $this->_value;
        }
        $validatedFields = $this->form->validatedFields();
        if(isset($validatedFields[$this->needleField])){
            $this->_value = new Field(
                $validatedFields[$this->needleField]
            );
            return $this->_value;
        }
        throw new \Exception('Field not exist', 400);
    }
}