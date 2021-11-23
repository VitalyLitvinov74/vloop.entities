<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 19.09.2021
 * Time: 13:02
 */

namespace vloop\entities\exceptions;


use vloop\entities\contracts\ExceptionsOfEntities;
use Yii;

abstract class AbstractException extends \Exception implements ExceptionsOfEntities
{
    protected $errors;

    /**
     * NotValidatedException constructor.
     * @param array $errors - массив ошибок.
     * @param int $code - код ошибки.
     */
    public function __construct(array $errors, int $code) {
        $this->errors = $errors;
        parent::__construct('', $code);
        Yii::$app->response->statusCode = $code;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}