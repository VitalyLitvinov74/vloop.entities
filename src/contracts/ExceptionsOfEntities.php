<?php


namespace vloop\entities\contracts;


interface ExceptionsOfEntities extends \Throwable
{
    public function errors(): array;
}