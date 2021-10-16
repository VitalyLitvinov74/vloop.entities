<?php


namespace vloop\entities\exceptions;


class FileNotFound extends AbstractException
{
    public function __construct(string $description, string $title = 'Файл') {
        parent::__construct([
            $title=>[$description]
        ], 404);
    }
}