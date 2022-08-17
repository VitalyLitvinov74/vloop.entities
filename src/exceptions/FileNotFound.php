<?php


namespace vloop\entities\exceptions;


class FileNotFound extends AbstractException
{
    public function __construct(string $description, string $title = 'Файл', string $message = 'File not found')
    {
        parent::__construct([
            $title => [$description]
        ], 404, $message);
    }
}