<?php


namespace vloop\entities\exceptions;


use Throwable;
use vloop\entities\contracts\ExceptionInterface;
use vloop\entities\contracts\ExceptionsOfEntities;

class NotFoundEntity extends AbstractException
{
    private $title;

    public function __construct(string $title, string $description) {
        $this->title = $title;
        parent::__construct([$title, $description], 404);
    }
}