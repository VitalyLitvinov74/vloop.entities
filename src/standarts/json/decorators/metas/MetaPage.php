<?php


namespace vloop\entities\standarts\json\decorators\meta;


use vloop\entities\contracts\IField;

class MetaPage implements IMeta
{
    private $fields;

    /**
     * PageMetaData constructor.
     * @param IField[] $fieldForPageMeta
     */
    public function __construct(array $fieldForPageMeta)
    {
        $this->fields = $fieldForPageMeta;
    }

    /**
     * @return array - печатает себя в виде массива.
     * Если в объекте есть вложенные объекты и коллекции - преобразует их в массив.
     */
    public function printYourSelf(): array
    {
        $page = [];
        foreach ($this->fields as $field) {
            $page = array_merge($page, $field->printYourSelf());
        }
        return [
            'page' => $page
        ];
    }
}