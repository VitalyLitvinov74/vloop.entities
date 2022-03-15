<?php


namespace vloop\entities\standarts\json\decorators;


use vloop\entities\exceptions\AbstractException;
use vloop\entities\standarts\json\IJsonStandart;

class WithHandlingExceptions implements IJsonStandart
{

    private $exception;

    public function __construct(AbstractException $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @return array - печатает себя в виде массива.
     * Если в объекте есть вложенные объекты и коллекции - преобразует их в массив.
     */
    public function printYourSelf(): array
    {
        return [
            'errors'=>$this->errors()
        ];
    }

    private function errors():array
    {
        $exception = $this->exception;
        $exceptionErrors = $exception->errors();
        $answer = [];
        foreach ($exceptionErrors as $attribute=>$errors){
            foreach ($errors as $concreteErrorDescription){
                $answer[] = [
                    "title"=>$attribute,
                    'description'=>$concreteErrorDescription
                ];
            }
        }
        return $answer;
    }
}