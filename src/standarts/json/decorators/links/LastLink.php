<?php


namespace vloop\entities\standarts\json\decorators\links;


use vloop\entities\contracts\IForm;
use vloop\entities\exceptions\NotValidatedFields;
use vloop\entities\standarts\json\decorators\meta\WithTotalCountMetaPage;
use vloop\entities\yii2\forms\PaginationForm;
use vloop\entities\yii2\urls\CurrentUrl;
use Yii;
use yii\helpers\Url;

class LastLink implements ILink
{
    private $totalCountMeta;
    private $pageForm;
    private $currentUrl;

    /**
     * LastLink constructor.
     * @param IForm|PaginationForm   $pageForm
     * @param WithTotalCountMetaPage $totalCountMeta
     */
    public function __construct(IForm $pageForm, WithTotalCountMetaPage $totalCountMeta)
    {
        $this->totalCountMeta = $totalCountMeta;
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
        $totalCount = $this->totalCountMeta->value();
        if($totalCount <= $fields['after'] or $totalCount <= $fields['after'] + $fields['size']){
            return [];
        }
        return [
            'last'=>$this->value()
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
            'before' => (int)$this->totalCountMeta->value() + 1,
            'size' => $fields['size']
        ];
        return $oldParams;
    }
}