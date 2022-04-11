<?php


namespace vloop\entities\contracts;


interface WeExceptions extends \Throwable
{
    public function errors(): array;
}