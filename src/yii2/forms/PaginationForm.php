<?php


namespace vloop\entities\yii2\forms;


use vloop\entities\contracts\IForm;
use vloop\entities\exceptions\NotValidatedFields;
use vloop\entities\yii2\AbstractForm;

class PaginationForm extends AbstractForm
{
    public $before;
    public $after;
    public $size;

    public function __construct($method = 'get', $config = ['formName'=>'page'])
    {
        parent::__construct($method, $config);
    }

    public function rules()
    {
        return [
            [['after', 'before', 'size'], 'integer'],
            ['size', 'default', 'value' => function ($model, $attribute) {
                if (is_null($model->before) and is_null($model->after)) {
                    return 10;
                }
                if (is_null($model->before) and !is_null($model->after)) {
                    return 10;
                }
                if (!is_null($model->before) and is_null($model->after)) {
                    return $model->before - 1;
                }
                if (!is_null($model->before) and !is_null($model->after)) {
                    return $model->before - $model->after - 1;
                }
                return 10;
            }],
            ['after', 'default', 'value' => function ($model, $attribute) {
                if (is_null($model->size) and is_null($model->before)) {
                    return 0;
                }
                if (!is_null($model->size) and is_null($model->before)) {
                    return 0;
                }
                if (!is_null($model->size) and !is_null($model->before)) {
                    $offset = $model->before - $model->size - 1;
                    if ($offset > 0) {
                        return $offset;
                    }
                    if ($offset < 0) { //тут ошибка.
                        $model->size = $model->before - 1;
                    }
                    return 0;
                }
                if (is_null($model->size) and !is_null($model->before)) {
                    return 0;
                }
                return 0;
            }]
        ];
    }
}