<?php


namespace vloop\entities\contracts;


interface DiffEntity
{
    public function apply(Entity $origin);
}