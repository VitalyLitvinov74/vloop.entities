<?php


namespace vloop\entities\contracts;


use vloop\entities\exceptions\NotValidatedFields;

interface IForm
{
    /**
     * @return array - проверенные поля в формате ключ=>значение
     * @throws NotValidatedFields
     */
    public function validatedFields(): array;
}