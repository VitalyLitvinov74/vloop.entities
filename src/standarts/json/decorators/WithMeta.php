<?php


namespace vloop\entities\standarts\json\decorators;


use vloop\entities\standarts\json\decorators\meta\IMeta;
use vloop\entities\standarts\json\IJsonStandart;
use vloop\entities\standarts\json\JsonStandart;

class WithMeta implements IJsonStandart
{

    private $origin;
    private $metas;

    /**
     * WithMeta constructor.
     * @param JsonStandart $origin
     * @param IMeta[] $metas
     */
    public function __construct(JsonStandart $origin, array $metas)
    {
        $this->metas = $metas;
        $this->origin = $origin;
    }

    /**
     * @return array - печатает себя в виде массива.
     * Если в объекте есть вложенные объекты и коллекции - преобразует их в массив.
     */
    public function printYourSelf(): array
    {
        $metasApi = [];
        foreach ($this->metas as $meta) {
            $metasApi = array_merge($metasApi, $meta->printYourSelf());
        }
        return array_merge(['meta'=>$metasApi], $this->origin->printYourSelf());
    }
}