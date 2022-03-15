<?php


namespace vloop\entities\standarts\json\decorators\links;


use vloop\entities\contracts\IForm;
use vloop\entities\exceptions\NotValidatedFields;
use vloop\entities\yii2\forms\PaginationForm;
use vloop\entities\yii2\urls\CurrentUrl;
use Yii;
use yii\helpers\Url;

class PrevLink implements ILink
{
    private $currentUrl;
    private $pageForm;

    /**
     * PrevLink constructor.
     * @param IForm|PaginationForm $paginatedForm
     */
    public function __construct(IForm $paginatedForm)
    {
        $this->currentUrl = new CurrentUrl();
        $this->pageForm = $paginatedForm;
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
            true);
    }

    /**
     * @return array - печатает себя в виде массива.
     * Если в объекте есть вложенные объекты и коллекции - преобразует их в массив.
     * @throws NotValidatedFields
     */
    public function printYourSelf(): array
    {
        $fields = $this->pageForm->validatedFields();
        if($fields['after'] == 0){ //если находимя на 1 странице, то предыдущей быть не должно.
            return [];
        }
        return [
            'prev' => $this->value()
        ];
    }

    /**
     * @return array
     * @throws NotValidatedFields
     */
    private function urlParams(): array
    {
        $oldParams = Yii::$app->request->get();
        $fields = $this->pageForm->validatedFields();
        $oldParams['page'] = [
            'before' => $fields['after'] + 1,
            'size'=> $fields['size']
        ];
        return $oldParams;
    }
}