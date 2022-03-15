<?php


namespace vloop\entities\standarts\json\decorators\links;


use vloop\entities\contracts\IForm;
use vloop\entities\exceptions\NotValidatedFields;
use vloop\entities\standarts\json\decorators\meta\WithTotalCountMetaPage;
use vloop\entities\yii2\urls\CurrentUrl;
use Yii;
use yii\helpers\Url;

class NextLink implements ILink
{
    private $currentUrl;
    private $pageForm;
    private $countMeta;


    /**
     * NextLink constructor.
     * @param IForm                  $pageForm
     * @param WithTotalCountMetaPage $countMeta
     */
    public function __construct(IForm $pageForm, WithTotalCountMetaPage $countMeta)
    {
        $this->currentUrl = new CurrentUrl();
        $this->pageForm = $pageForm;
        $this->countMeta = $countMeta;
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
        $totalCount = $this->countMeta->value();
        if($totalCount <= $fields['after'] or $totalCount <= $fields['after'] + $fields['size']){ //т.е. если мы на последней странице
            return [];
        }
        return [
            'next' => $this->value()
        ];
    }

    /**
     * @return array
     * @throws NotValidatedFields
     */
    private function urlParams():array
    {
        $fields = $this->pageForm->validatedFields();
        $oldParams = Yii::$app->request->get();
        $oldParams['page'] = [
            'after'=>$fields['after'] + $fields['size'],
            'size'=>$fields['size']
        ];
        return $oldParams;
    }
}