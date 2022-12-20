<?php


namespace vloop\entities\fields;


use vloop\entities\contracts\IField;

class Field implements IField
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function asInt(): int
    {
        return (int) $this->value;
    }

    public function asFloat(): float
    {
        return (float) $this->value;
    }

    public function asBool(): bool
    {
        return (bool) $this->value;
    }

    public function asString(): string
    {
        return (string) $this->value;
    }

    /**
     * @return mixed
     */
    private function value()
    {
        return $this->value;
    }
}