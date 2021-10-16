<?php


namespace vloop\entities\contracts;


use yii\web\UploadedFile;

interface FileEntities
{
    /**
     * @return array - список файлов в дирректории
     */
    public function list(): array;

    /**
     * @param $uploadedFile
     * @return mixed
     */
    public function addFile($uploadedFile): Entity;

    /**
     * @param int|string $name - идентификатор файла (с расщирением)
     * @return Entity
     */
    public function entity(string $name): Entity;

    /**
     * @return bool - является ли данная сущность нулевым обхектом
     */
    public function isNull(): bool;
}