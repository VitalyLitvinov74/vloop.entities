<?php


namespace vloop\entities\exceprions;


use vloop\entities\contracts\ExceptionsOfEntities;
/**
 * Позволяет перехватить список ошибок в любом месте программы.
*/
class NotValidatedFieldsException extends \Exception implements ExceptionsOfEntities
{
    private $errors;

    /**
     * NotValidatedException constructor.
     * @param array $errors - массив ошибок.
     * @param int $code - код ошибки.
     */
    public function __construct(array $errors, int $code) {
        $this->errors = $errors;
        parent::__construct('', $code);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}