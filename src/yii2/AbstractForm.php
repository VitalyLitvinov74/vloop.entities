<?php


namespace vloop\entities\yii2;


use vloop\entities\contracts\Form;
use vloop\entities\exceptions\NotValidatedFields;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

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
        $this->loadData();
        if ($this->validate()) {
            $fields = $this->unsetNull($this->getAttributes());
            return $fields;
        }
        throw new NotValidatedFields($this->getErrors(), 400);
    }

    private function loadData(){
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();
        if ($this->method == 'post' and $this->load($post, '')) {
            return true;
        } elseif ($this->method == 'get' and $this->load($get, '')) {
            return true;
        }
        return false;
    }

    private function unsetNull(array $fields):array {
        foreach ($fields as $key=>$field){
            if(is_null($field)){
                unset($fields[$key]);
            }
        }
        return $fields;
    }
}