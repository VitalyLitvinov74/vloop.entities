<?php


namespace vloop\entities\standarts\json;


use vloop\PrintYourSelf\PrintYourSelf;

class JsonStandart implements IJsonStandart
{

    private $origin;
    private $isList;
    private $ignoreAttributes;
    private $objectType;

    /**
     * ToJsonApi constructor.
     * @param PrintYourSelf $object           - объект который необходимо преобразовать в jsonApi
     * @param string        $objectType       - тип объекта, который нужно передать на фронт
     * @param bool          $isList           - указывает на то, является ли передаваемый объект - коллекцией (списком)
     * @param array         $ignoreAttributes - какие аттрибуты нужно исключить из сущноти (сущностей)
     */
    public function __construct(PrintYourSelf $object,
                                string $objectType,
                                bool $isList = true,
                                array $ignoreAttributes = [])
    {
        $this->origin = $object;
        $this->isList = $isList;
        $this->ignoreAttributes = $ignoreAttributes;
        $this->objectType = $objectType;
    }

    /**
     * @return array - печатает себя в виде массива.
     * Если в объекте есть вложенные объекты и коллекции - преобразует их в массив.
     */
    public function printYourSelf(): array
    {
        return $this->isList ? $this->createForList() : $this->createForOne();
    }

    /**
     * @return array - печатает jsonApi для списка.
     */
    private function createForList(): array
    {
        $printedOriginList = $this->origin->printYourSelf();
        $transformedList = [];
        foreach ($printedOriginList as $printedObject){
            $transformedList[] = $this->transformArray($printedObject);
        }
        return [
            'data' => $transformedList
        ];
    }

    /**
     * @return array - печатает jsonApi для конкретного объекта.
     */
    private function createForOne(): array
    {
        $printedOriginObject = $this->origin->printYourSelf();
        return [
            'data' => $this->transformArray($printedOriginObject)
        ];
    }

    private function transformArray(array $printedObject)
    {
        $id = $printedObject['id'];
        $type = $this->objectType;
        unset($printedObject['id']);
        return [
            'id' => $id,
            'type' => $type,
            'attributes' => $printedObject
        ];
    }
}