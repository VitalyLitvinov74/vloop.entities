<?php


namespace vloop\entities\standarts\json\decorators\links;


use vloop\entities\contracts\IForm;
use vloop\entities\exceptions\NotValidatedFields;
use vloop\entities\yii2\urls\CurrentUrl;
use Yii;
use yii\helpers\Url;

class FirstLink implements ILink
{
    private $pageForm;
    private $currentUrl;

    /**
     * FirstLink constructor.
     * @param IForm $pageForm
     */
    public function __construct(IForm $pageForm)
    {
        $this->pageForm = $pageForm;
        $this->currentUrl = new CurrentUrl();
    }

    /**
     * @return string
     * @throws NotValidatedFields
     */
    public function value(): string
    {
        return Url::to(
            array_merge(
                [$this->currentUrl->value()],
                $this->urlParams()
            ),
            true
        );
    }

    /**
     * @return array - печатает себя в виде массива.
     * Если в объекте есть вложенные объекты и коллекции - преобразует их в массив.
     * @throws NotValidatedFields
     */
    public function printYourSelf(): array
    {
        $fields = $this->pageForm->validatedFields();
        if($fields['after'] == 0){
            return [];
        }
        return [
            'first'=>$this->value()
        ];
    }

    /**
     * @throws NotValidatedFields
     */
    private function urlParams(): array {
        $oldParams = Yii::$app->request->get();
        $oldParams['page'] = [
            'after'=> 0,
            'size'=> $this->pageForm->validatedFields()['size']
        ];
        return $oldParams;
    }
}