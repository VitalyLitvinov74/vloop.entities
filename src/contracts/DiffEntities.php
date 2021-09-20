<?php


namespace vloop\entities\contracts;


interface DiffEntities
{
    public function apply(Entities $origin);
}