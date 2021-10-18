<?php


namespace vloop\entities\contracts;


interface Entity
{
    public function id(): int;

    /**
     * @return array - печатает себя в виде массива
     */
    public function printYourself(): array;

    /**
     * @param Form $form - форма из которой следует брать провалидированные значения
     * @return Entity - возвращает себя же.
     */
    public function changeLineData(Form $form): Entity;

    /**
     * удаляет себя насовсем.
     */
    public function remove(): void;

    /**
     * Реализаует паттерн NullObject
    */
    public function isNull(): bool;
}