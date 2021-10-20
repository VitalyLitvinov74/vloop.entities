<?php


namespace vloop\entities\yii2\transaction;


use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use vloop\entities\exceptions\NotFoundEntity;
use vloop\entities\exceptions\NotSavedData;
use vloop\entities\exceptions\NotValidatedFields;
use Yii;

class EntityInSQLTransaction implements Entity
{
    use EntitiesTransactionTrait;

    private $origin;

    public function __construct(Entity $origin)
    {
        $this->origin = $origin;
    }

    /**
     * @return string|int
     */
    public function id()
    {
        return $this->origin->id();
    }

    /**
     * @return array - печатает себя в виде массива
     */
    public function printYourself(): array
    {
        return $this->origin->printYourself();
    }

    /**
     * @param Form $form - форма из которой следует брать провалидированные значения
     * @return Entity - возвращает себя же.
     * @throws NotFoundEntity
     * @throws NotSavedData
     * @throws NotValidatedFields
     * @throws \yii\db\Exception
     */
    public function changeLineData(Form $form): Entity
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $entity = $this->origin->changeLineData($form);
            $transaction->commit();
            return $entity;
        } catch (NotFoundEntity $exception) {
            $transaction->rollBack();
            throw new NotFoundEntity(
                $this->descNotFoundEntity($exception),
                $this->titleNotFountEntity($exception)
            );
        } catch (NotSavedData $exception) {
            $transaction->rollBack();
            throw new NotSavedData($exception->errors(), $exception->getCode());
        } catch (NotValidatedFields $exception) {
            throw new NotValidatedFields($exception->errors(), $exception->getCode());
        }
    }

    /**
     * удаляет себя насовсем.
     * @return void
     * @throws NotFoundEntity
     * @throws NotSavedData
     * @throws NotValidatedFields
     * @throws \yii\db\Exception
     */
    public function remove(): void
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
           $this->origin->remove();
            $transaction->commit();
        } catch (NotFoundEntity $exception) {
            $transaction->rollBack();
            throw new NotFoundEntity(
                $this->descNotFoundEntity($exception),
                $this->titleNotFountEntity($exception)
            );
        } catch (NotSavedData $exception) {
            $transaction->rollBack();
            throw new NotSavedData($exception->errors(), $exception->getCode());
        } catch (NotValidatedFields $exception) {
            throw new NotValidatedFields($exception->errors(), $exception->getCode());
        }
    }

    /**
     * Реализаует паттерн NullObject
     */
    public function isNull(): bool
    {
        return $this->origin->isNull();
    }
}