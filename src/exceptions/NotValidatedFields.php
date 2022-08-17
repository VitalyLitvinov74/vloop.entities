<?php


namespace vloop\entities\exceptions;

/**
 * Позволяет перехватить список ошибок в любом месте программы.
 */
class NotValidatedFields extends AbstractException
{
    public function __construct(array $errors, int $code = 409, string $message = 'Not validated fields')
    {
        parent::__construct($errors, $code, $message);
    }
}