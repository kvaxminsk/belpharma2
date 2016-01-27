<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use app\modules\user\models\User;

class PasswordChangeForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $newPasswordRepeat;
    
    public $_user;
    
    public function __construct(User $user, $config = array()) 
    {
        if(empty($user))
        {
            throw new InvalidParamException('User is empty.');
        }
        $this->_user = $user;
        parent::__construct($config);
    }
    
    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'newPasswordRepeat'], 'required'],
            [['currentPassword'], 'validatePassword'],
            [['newPassword'], 'string', 'min' => 6],
            [['newPasswordRepeat'], 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }
    
    public function validatePassword($attribute, $params)
    {
        if(!$this->hasErrors())
        {
            if(!$this->_user->validatePassword($attribute))
            {
                $this->addError($attribute, Yii::t('app', 'ERROR_WRONG_CURRENT_PASSWORD'));
            }
        }
    }
    
    public function changePassword()
    {
        if($this->validate())
        {
            $this->_user->setPassword($this->newPassword);
            return $this->_user->save();
        } else {
            return false;
        }
    }
}
