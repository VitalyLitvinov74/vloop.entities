<?php


namespace vloop\entities\decorators\exceptions;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use vloop\entities\decorators\rest\jsonapi\decorators\EntityInErrorsField;
use vloop\entities\exceptions\errors\NestedArrayAsEntity;
use vloop\entities\exceptions\NotFoundEntity;
use vloop\entities\exceptions\NotSavedData;
use vloop\entities\exceptions\NotValidatedFields;

class HandledExceprionsOfEntities implements Entities
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

        }
        catch (NotValidatedFields $e){

        }
        catch (NotFoundEntity $e){

        }
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Новая сущность которая только что была создана
     */
    public function add(Form $form): Entity
    {
        try{

        }catch (NotValidatedFields $e){

        }catch (NotSavedData $e){

        }
    }

    /**
     * @param int $id
     * @return Entity - конкретная сущность из массив.
     */
    public function entity(int $id): Entity
    {
        try{
            return $this->origin->entity($id);
        }catch (NotFoundEntity $e){

        }catch (NotValidatedFields $e){
            return $this->errorsAsEntity($e->errors());
        }catch (NotSavedData $e){
            return $this->errorsAsEntity($e->errors());
        }
    }

    private function errorsAsEntity(array $errors){
        return new EntityInErrorsField( //оборачивает сущность в поле Errors
            new NestedArrayAsEntity($errors) //Вложенный массив в виде сущности.
        );
    }
}