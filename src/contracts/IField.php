<?php
namespace vloop\entities\contracts;

interface IField
{
    public function asInt(): int;

    public function asFloat(): float;

    public function asBool(): bool;

    public function asString(): string ;
}