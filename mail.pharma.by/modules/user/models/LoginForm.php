<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],            
            ['rememberMe', 'boolean'],            
            ['password', 'validatePassword'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'LABEL_USERNAME'),
            'password' => Yii::t('app', 'LABEL_PASSWORD'),
            'rememberMe' => Yii::t('app', 'LABEL_REMEMBERME'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('app', 'USER_LOGIN_WRONGPASS'));
            } elseif ($user && $user->status == User::STATUS_BLOCKED) {
                $this->addError('username', Yii::t('app', 'USER_LOGIN_BLOCKED'));
            } elseif ($user && $user->status == User::STATUS_WAIT) {
                $this->addError('username', Yii::t('app', 'USER_LOGIN_WAIT'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
