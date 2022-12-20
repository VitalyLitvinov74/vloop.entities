<?php


namespace vloop\entities\fields;


use vloop\entities\contracts\IField;
use vloop\entities\contracts\IForm;
use vloop\entities\exceptions\NotValidatedFields;

class FieldOfForm implements IField
{
    private $form;
    private $needleField;

    public function __construct(IForm $form, string $needleField)
    {
        $this->form = $form;
        $this->needleField = $needleField;
    }

    public function asInt(): int
    {
        return (int) $this->value();
    }

    public function asFloat(): float
    {
        return (float) $this->value();
    }

    public function asBool(): bool
    {
        return (bool) $this->value();
    }

    public function asString(): string
    {
        return (string) $this->value();
    }

    /**
     * @return mixed
     * @throws NotValidatedFields
     */
    private function value(){
        $fields = $this->form->validatedFields();
        return $fields[$this->needleField];
    }
}