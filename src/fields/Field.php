<?php


namespace vloop\entities\fields;


use vloop\entities\contracts\IField;

class Field implements IField
{
    private $key;
    private $value;

    public function __construct(string $key, string $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function printYourSelf(): array
    {
        return [
            $this->key => $this->value
        ];
    }
}