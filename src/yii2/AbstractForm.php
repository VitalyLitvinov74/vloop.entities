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
        static $fields = false;
        if(is_array($fields)){
            return $fields;
        }
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();
        if ($this->method == 'post' and $this->load($post, '')) {
            $this->validatedFields();
        } elseif ($this->method == 'get' and $this->load($get, '')) {
            $this->validatedFields();
        }
        return [];
    }

    private function validateFields(){
        if ($this->validate()) {
            $fields = $this->getAttributes();
            return $fields;
        }
        throw new NotValidatedFields($this->getErrors(), 400);
    }
}