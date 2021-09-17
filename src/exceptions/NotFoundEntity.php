<?php


namespace vloop\entities\exceptions;


use Throwable;
use vloop\entities\contracts\ExceptionsOfEntities;

class NotFoundEntity extends \Exception
{
    public function __construct($message) {
        parent::__construct($message, 404);
    }
}