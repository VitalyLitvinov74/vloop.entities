<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 19.09.2021
 * Time: 13:02
 */

namespace vloop\entities\exceptions;


use vloop\entities\contracts\WeExceptions;

class NotSavedData extends AbstractException
{
    public function __construct(array $errors, int $code, string $message = 'Not saved data')
    {
        parent::__construct($errors, $code, $message);
    }

}