<?php


namespace vloop\entities\yii2;


use vloop\entities\contracts\IForm;
use vloop\entities\exceptions\NotValidatedFields;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

abstract class AbstractForm extends Model implements IForm
{
    //update tag
    protected $method;
    public $formName = '';
    private $_fields = false;

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
        $fields = $this->_fields;
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
        if ($this->method == 'post' and $this->load($post, $this->formName)) {
            return true;
        } elseif ($this->method == 'get' and $this->load($get, $this->formName)) {
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