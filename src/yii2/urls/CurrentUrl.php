<?php


namespace vloop\entities\yii2\urls;


use vloop\entities\contracts\IField;
use Yii;

class CurrentUrl implements IField
{
    private function value(): string
    {
        return '/' . Yii::$app->requestedRoute;
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
        return (bool) $this->value();
    }
}