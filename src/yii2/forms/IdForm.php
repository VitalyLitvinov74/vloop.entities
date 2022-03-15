<?php


namespace vloop\entities\yii2\forms;


use vloop\entities\contracts\IForm;
use vloop\entities\exceptions\NotValidatedFields;
use vloop\entities\yii2\AbstractForm;

class IdForm extends AbstractForm
{

    public $id;

    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'integer']
        ];
    }
}