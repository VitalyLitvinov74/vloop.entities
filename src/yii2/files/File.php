<?php


namespace vloop\entities\yii2\files;


use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use yii\helpers\FileHelper;

class File implements Entity
{
    private $path;

    public function __construct(string $path) {
        $this->path = $path;
    }

    public function id(): int
    {
        return (int) pathinfo($this->path,PATHINFO_FILENAME);
    }

    /**
     * @return array - печатает себя в виде массива
     */
    public function printYourself(): array
    {
        $pathInfo = pathinfo($this->path);
        $pathInfo['path'] = $this->path;
        return $pathInfo;
    }

    /**
     * @param Form $form - форма из которой следует брать провалидированные значения
     * @return Entity - возвращает себя же.
     */
    public function changeLineData(Form $form): Entity
    {
        return $this;
    }

    /**
     * удаляет себя насовсем.
     */
    public function remove(): void
    {
        FileHelper::unlink($this->path);
    }

    /**
     * Реализаует паттерн NullObject
     */
    public function isNull(): bool
    {
        return false;
    }

    public function __toString()
    {
        return (string) pathinfo($this->path, PATHINFO_BASENAME);
    }
}