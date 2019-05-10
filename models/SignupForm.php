<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\validators\EmailOrPhoneValidator;

/**
 * Signup form
 */
class SignupForm extends Model
{

    public $username;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => \Yii::t('app', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', EmailOrPhoneValidator::className()],
        ];
    }
    
    /**
     * Generates user password.
     * 
     * For the purposes of this demonstration, the hard-coded 'user' password is 
     * used for every new user.
     * 
     * @return string
     */
    protected function generatePassword()
    {
        if (!$this->password) {
            $this->password = 'user';
        }
        
        return $this->password;
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->generatePassword());
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }

}