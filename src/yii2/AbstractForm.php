<?php


namespace vloop\entities\yii2;


use vloop\entities\contracts\Form;
use vloop\entities\exceptions\NotValidatedFields;
use Yii;
use yii\base\Model;

class AbstractForm extends Model implements Form
{
    //update tag
    protected $method;

    public function __construct($method = 'post', $config = [])
    {
        $this->method = $method;
        parent::__construct($config);
    }

    /**
     * @return array
     * @throws NotValidatedFields
     */
    public function validatedFields(): array
    {
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();
        if ($this->method == 'post') {
            if ($this->load($post, '') and $this->validate()) {
                return $this->getAttributes();
            }
        } elseif ($this->method == 'get') {
            if ($this->load($get, '') and $this->validate()) {
                return $this->getAttributes();
            }
        }
        throw new NotValidatedFields($this->getErrors(), 400);
    }
}