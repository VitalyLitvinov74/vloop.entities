<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 19.09.2021
 * Time: 13:02
 */

namespace vloop\entities\exceptions;


use vloop\entities\contracts\WeExceptions;
use Yii;

abstract class AbstractException extends \Exception implements WeExceptions
{
    protected $errors;

    /**
     * NotValidatedException constructor.
     * @param array $errors - массив ошибок.
     * @param int $code - код ошибки.
     */
    public function __construct(array $errors, int $code, string $message = '') {
        $this->errors = $errors;
        parent::__construct($message, $code);
        Yii::$app->response->statusCode = $code;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}