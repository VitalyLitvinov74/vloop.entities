<?php


namespace vloop\entities\yii2;


use Throwable;
use Yii;

class Transaction
{

    private $needleTables;

    /**
     * Transaction constructor.
     * @param array $needleCommitTables - [ActiveRecord1::class, ActiveRecord2::class]
     */
    public function __construct(array $needleCommitTables = [])
    {
        $this->needleTables = $needleCommitTables;
    }

    /**
     * @param callable $callback
     * @return mixed
     * @throws Throwable
     */
    public function begin(callable $callback)
    {
        $beginedTransactions = $this->beginedTransactions();
        try {
            $result = call_user_func($callback);
            $this->commitTransactions($beginedTransactions);
            return $result;
        } catch (Throwable $exception) {
            $this->rollbackTransactions($beginedTransactions);
            throw $exception;
        }
    }

    /**
     * @return \yii\db\Transaction[]
     */
    private function beginedTransactions(): array
    {
        $transctions = [];
        if (empty($this->needleTables)) {
            $transctions[] = Yii::$app->getDb()->beginTransaction();
        } else {
            foreach ($this->needleTables as $table) {
                $transctions[] = $table::getDb()->beginTransaction();
            }
        }
        return $transctions;
    }

    /**
     * @param Transaction[] $transactions
     */
    private function rollbackTransactions(array $transactions): void
    {
        foreach ($transactions as $transaction) {
            $transaction->rollBack();
        }
    }

    /**
     * @param \yii\db\Transaction[] $transactions
     * @throws \yii\db\Exception
     */
    private function commitTransactions(array $transactions): void
    {
        foreach ($transactions as $transaction) {
            $transaction->commit();
        }
    }
}