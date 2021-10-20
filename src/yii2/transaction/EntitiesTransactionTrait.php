<?php


namespace vloop\entities\yii2\transaction;


use vloop\entities\exceptions\NotFoundEntity;

trait EntitiesTransactionTrait
{
    private function titleNotFountEntity(NotFoundEntity $e){
        return  array_key_first($e->errors());
    }

    private function descNotFoundEntity(NotFoundEntity $e){
        return $e->errors()[$this->titleNotFountEntity($e)];
    }
}