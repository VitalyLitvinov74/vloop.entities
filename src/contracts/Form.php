<?php


namespace vloop\entities\contracts;


interface Form
{
    /**
     * @return array - проверенные поля в формате ключ=>значение
     */
    public function validatedFields(): array;
}