<?php


namespace vloop\entities\yii2;


use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use Yii;

/**
 * Добавляет, к распечатке самго себя, карту атрибутов с переводом этих аттрибутов на русский язык.
 * т.е. если есть поле, description то к массиву printYourself будет добавлено следующее
 * [
 *  'description' => "Hello world",
 *  'map' => [
 *      'description'=> 'Описание'
 *  ]
 * Class EntityWithI18nData
 * @package vloop\entities\yii2
 */
class EntityWithI18nData implements Entity
{
    private $origin;

    public function __construct(Entity $origin) {
        $this->origin = $origin;
    }

    /**
     * @inheritDoc
     */
    public function id()
    {
        return $this->origin->id();
    }

    /**
     * @inheritDoc
     */
    public function printYourself(): array
    {
        $old = $this->origin->printYourself();
        $mappedFields = [];
        foreach ($old as $key=>$value){
            $mappedFields[$key] = Yii::t('app', $key);
        }
        $old['mappedFields'] = $mappedFields;
        return $old;
    }

    /**
     * @inheritDoc
     */
    public function changeLineData(Form $form): Entity
    {
        $this->origin->changeLineData($form);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function remove(): void
    {
        $this->origin->remove();
    }

    /**
     * @inheritDoc
     */
    public function isNull(): bool
    {
        return $this->origin->isNull();
    }
}