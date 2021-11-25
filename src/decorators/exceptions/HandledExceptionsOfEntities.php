<?php


namespace vloop\entities\decorators\exceptions;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use vloop\entities\exceptions\errors\ErrorsAsEntity;
use vloop\entities\exceptions\NotFoundEntity;
use vloop\entities\exceptions\NotSavedData;
use vloop\entities\exceptions\NotValidatedFields;
use Yii;
use yii\helpers\VarDumper;

class HandledExceptionsOfEntities implements Entities
{
    private $origin;

    function __construct(Entities $origin)
    {
        $this->origin = $origin;
    }

    /**
     * @return Entity[] - массив вида [id=>Entity]
     */
    public function list(): array
    {
        try{
            return $this->origin->list();
        }
        catch (NotSavedData $e){
            return $this
                ->errorsAsEntity($e->errors())
                ->printYourself();
        }
        catch (NotValidatedFields $e){
            return $this
                ->errorsAsEntity($e->errors())
                ->printYourself();
        }
        catch (NotFoundEntity $e){
            return $this
                ->errorsAsEntity($e->errors())
                ->printYourself();
        }
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Новая сущность которая только что была создана
     */
    public function add(Form $form): Entity
    {
        try{
            return new HandledExceptionsOfEntity(
                $this->origin->add($form)
            );
        }catch (NotValidatedFields $e){
            return $this->errorsAsEntity($e->errors());
        }catch (NotSavedData $e){
            return $this->errorsAsEntity($e->errors());
        }
    }

    /**
     * @param int $id
     * @return Entity - конкретная сущность из массив.
     */
    public function entity(int $id): Entity
    {
        try{
            return new HandledExceptionsOfEntity(
                $this->origin->entity($id)
            );
        }catch (NotFoundEntity $e){
            return $this->errorsAsEntity($e->errors());
        }catch (NotValidatedFields $e){
            return $this->errorsAsEntity($e->errors());
        }catch (NotSavedData $e){
            return $this->errorsAsEntity($e->errors());
        }
    }

    private function errorsAsEntity(array $errors){
        return new ErrorsAsEntity($errors);
    }

    /**
     * Реализует паттерн NullObject
     */
    public function isNull(): bool
    {
        return false; //под вопросом, является ли это место нулевым объектом.
    }
}