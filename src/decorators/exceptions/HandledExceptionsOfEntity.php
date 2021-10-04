<?php


namespace vloop\entities\decorators\exceptions;


use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use vloop\entities\exceptions\errors\ErrorsAsEntity;
use vloop\entities\exceptions\NotFoundEntity;
use vloop\entities\exceptions\NotSavedData;
use vloop\entities\exceptions\NotValidatedFields;

class HandledExceptionsOfEntity implements Entity
{
    private $origin;

    public function __construct(Entity $origin)
    {
        $this->origin = $origin;
    }

    public function id(): int
    {
        return $this->origin->id();
    }

    /**
     * @return array - печатает себя в виде массива
     */
    public function printYourself(): array
    {
        try {
            return $this->origin->printYourself();
        } catch (NotFoundEntity $exception) {
            return $this->errorsAsEntity($exception->errors())->printYourself();
        } catch (NotSavedData $exception) {
            return $this->errorsAsEntity($exception->errors())->printYourself();
        } catch (NotValidatedFields $exception) {
            return $this->errorsAsEntity($exception->errors())->printYourself();
        }
    }

    private function errorsAsEntity(array $errors){
        return new ErrorsAsEntity($errors);
    }

    /**
     * @param Form $form - форма из которой следует брать провалидированные значения
     * @return Entity - возвращает себя же.
     */
    public function changeLineData(Form $form): Entity
    {
        try {
            return $this->origin->changeLineData($form);
        } catch (NotFoundEntity $exception) {
            return $this->errorsAsEntity($exception->errors());
        } catch (NotSavedData $exception) {
            return $this->errorsAsEntity($exception->errors());
        } catch (NotValidatedFields $exception) {
            return $this->errorsAsEntity($exception->errors());
        }
    }

    /**
     * удаляет себя насовсем.
     */
    public function remove(): void
    {
        try {
             $this->origin->remove();
        } catch (NotFoundEntity $exception) {
             $this->errorsAsEntity($exception->errors())->remove();
        } catch (NotSavedData $exception) {
             $this->errorsAsEntity($exception->errors())->remove();
        } catch (NotValidatedFields $exception) {
             $this->errorsAsEntity($exception->errors())->remove();
        }
    }

    /**
     * Реализаует паттерн NullObject
     */
    public function isNull(): bool
    {
        return false;
    }
}