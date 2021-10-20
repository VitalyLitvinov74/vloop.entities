<?php


namespace vloop\entities\yii2\transaction;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use vloop\entities\exceptions\NotFoundEntity;
use vloop\entities\exceptions\NotSavedData;
use vloop\entities\exceptions\NotValidatedFields;
use Yii;
use yii\db\Exception;

class EntitiesInSQLTransaction implements Entities
{
    use EntitiesTransactionTrait;

    private $origin;
    private $transaction;

    public function __construct(Entities $origin) {
        $this->origin = $origin;
        $this->transaction = Yii::$app->db->beginTransaction();
    }

    /**
     * @return Entity[] - массив вида [id=>Entity]
     * @throws Exception
     * @throws NotFoundEntity
     * @throws NotSavedData
     * @throws NotValidatedFields
     */
    public function list(): array
    {
        $transaction = $this->transaction;
        try{
            $list = $this->origin->list();
            $transaction->commit();
            return $list;
        }
        catch (NotSavedData $e){
            $transaction->rollBack();
            throw new NotSavedData($e->errors(), $e->getCode());
        }
        catch (NotValidatedFields $e){
            $transaction->rollBack();
            throw new NotValidatedFields($e->errors(), $e->getCode());
        }
        catch (NotFoundEntity $e){ //не правильно
            $transaction->rollBack();
            throw new NotFoundEntity(
                $this->descNotFoundEntity($e),
                $this->titleNotFountEntity($e)
            );
        }
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Новая сущность которая только что была создана
     * @throws NotSavedData
     * @throws NotValidatedFields
     * @throws Exception
     */
    public function add(Form $form): Entity
    {
        $transaction = $this->transaction;
        try{
            $entity = $this->origin->add($form);
            $transaction->commit();
            return new EntityInSQLTransaction($entity);
        }catch (NotValidatedFields $e){
            $transaction->rollBack();
            throw new NotValidatedFields($e->errors(), $e->getCode());
        }catch (NotSavedData $e){
            $transaction->rollBack();
            throw new NotSavedData($e->errors(), $e->getCode());
        }
    }

    /**
     * @param int $id
     * @return Entity - конкретная сущность из массив.
     * @throws Exception
     * @throws NotSavedData
     * @throws NotValidatedFields
     * @throws NotFoundEntity
     */
    public function entity(int $id): Entity
    {
        $transaction = $this->transaction;
        try{
            $entity = $this->origin->entity($id);
            $transaction->commit();
            return new EntityInSQLTransaction($entity);
        }catch (NotFoundEntity $e){
            $transaction->rollBack();
            throw new NotFoundEntity(
                $this->descNotFoundEntity($e),
                $this->titleNotFountEntity($e)
            );
        }catch (NotValidatedFields $e){
            $transaction->rollBack();
            throw new NotValidatedFields($e->errors(), $e->getCode());
        }catch (NotSavedData $e){
            $transaction->rollBack();
            throw new NotSavedData($e->errors(), $e->getCode());
        }
    }

    /**
     * Реализует паттерн NullObject
     */
    public function isNull(): bool
    {
        return false;
    }
}