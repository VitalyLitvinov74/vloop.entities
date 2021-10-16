<?php


namespace vloop\entities\yii2\files;


use vloop\entities\contracts\Entity;
use vloop\entities\contracts\FileEntities;
use vloop\entities\exceptions\FileNotFound;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class Directory implements FileEntities
{

    private $dir;

    /**
     * @param string $dir - директория с файлами
     * стандартно - дирректория web/files
     */
    public function __construct(string $dir = 'files')
    {
        $this->dir = $dir;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return mixed
     */
    public function addFile($uploadedFile): Entity
    {
        $fileName = $uploadedFile->name;
        $dir = $this->dir;
        $path = $dir . '/' . $fileName;
        if (!file_exists($dir)) {
            mkdir($dir);
        }
        $uploadedFile->saveAs($path);
        $file = new File($path);
        return $file;
    }

    /**
     * @return Entity[] - массив вида [id=>Entity]
     */
    public function list(): array
    {
        $helperList = FileHelper::findFiles($this->dir, ['recursive' => false]);
        $list = [];
        foreach ($helperList as $file) {
            $list[pathinfo($file, PATHINFO_BASENAME)] = $file;
        }
        return $list;
    }

    /**
     * @param string $name
     * @return Entity - конкретная сущность из массив.
     * @throws FileNotFound
     */
    public function entity(string $name): Entity
    {
        $list = $this->list();
        if (key_exists($name, $list)) {
            return new File($list[$name]);
        }
        throw new FileNotFound('Файл не найден');
    }

    /**
     * Реализует паттерн NullObject
     */
    public function isNull(): bool
    {
        return false;
    }
}