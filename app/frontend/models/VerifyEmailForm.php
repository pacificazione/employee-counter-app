<?php

namespace frontend\models;

use common\models\Employee;
use yii\base\InvalidArgumentException;
use yii\base\Model;

class VerifyEmailForm extends Model
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var Employee
     */
    private $_employee;


    /**
     * Creates a form model with given token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, array $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Verify email token cannot be blank.');
        }
        $this->_employee = Employee::findByVerificationToken($token);
        if (!$this->_employee) {
            throw new InvalidArgumentException('Wrong verify email token.');
        }
        parent::__construct($config);
    }

    /**
     * Verify email
     *
     * @return Employee|null the saved model or null if saving fails
     */
    public function verifyEmail()
    {
        $user = $this->_employee;
        $user->status = Employee::STATUS_ACTIVE;
        return $user->save(false) ? $user : null;
    }
}
