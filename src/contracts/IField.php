<?php


namespace vloop\entities\contracts;


use vloop\PrintYourSelf\PrintYourSelf;

interface IField extends PrintYourSelf
{
    /**
     * @return string - возвращает значение поля
     */
    public function value(): string;

    /**
     * @return array - печатает само себя
     */
    public function printYourSelf(): array;
}