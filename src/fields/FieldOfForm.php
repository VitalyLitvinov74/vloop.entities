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

    /**
     * @return string
     * @throws NotValidatedFields
     */
    public function value(): string
    {
        $fields = $this->form->validatedFields();
        return $fields[$this->needleField];
    }

    /**
     * @return array
     * @throws NotValidatedFields
     */
    public function printYourSelf(): array
    {
        return [
            $this->needleField => $this->value()
        ];
    }
}