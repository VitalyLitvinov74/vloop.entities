<?php


namespace vloop\entities\exceptions;


use Throwable;
use vloop\entities\contracts\ExceptionInterface;
use vloop\entities\contracts\WeExceptions;

class NotFoundEntity extends AbstractException
{
    public function __construct(string $description, string $title = '') {
        if(!$title){
            $title = "Not Found Entity";
        }
        parent::__construct([$description], 404, $title);
    }
}