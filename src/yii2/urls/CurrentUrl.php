<?php


namespace vloop\entities\yii2\urls;


use vloop\entities\contracts\IField;
use Yii;

class CurrentUrl implements IField
{
    public function printYourSelf(): array
    {
        return [
            'currentUrl' => $this->value()
        ];
    }

    public function value(): string
    {
        return '/' . Yii::$app->requestedRoute;
    }
}