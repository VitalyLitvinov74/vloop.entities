<?php


namespace vloop\entities\decorators\rest\jsonapi;


trait JsonDataTrait
{
    private function jsonDataFromArray(string $needleType, array $data, array $needleFields = []): array
    {
        $array = [
            'type'=>$needleType,
            'id'=>$data['id'],
            'attributes'=>$this->attributes($data, $needleFields)
        ];
        return $array;
    }

    private function attributes(array $data, array $needleFields = []): array
    {
        $origArray = $data;
        $attributes = [];
        if ($needleFields) {
            foreach ($needleFields as $needleField) {
                if (array_key_exists($needleField, $origArray)) {
                    $attributes[$needleField] = $origArray[$needleField];
                }
            }
        } else {
            $attributes = $origArray;
        }
        unset($attributes['id']);
        return $attributes;
    }
}