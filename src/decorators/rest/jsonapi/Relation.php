<?php


namespace vloop\entities\decorators\rest\jsonapi;


trait Relation
{
    use JsonDataTrait;

    private function moveToRelation(array &$dataValues, string $needleAttribute)
    {
        if (array_key_exists($needleAttribute, $dataValues['attributes'])) {
            $dataValues['relationships'][$needleAttribute]['data'] = $this->jsonDataFromArray(
                $needleAttribute,
                $dataValues['attributes'][$needleAttribute]
            );
            unset($dataValues['attributes'][$needleAttribute]);
        }
    }
}