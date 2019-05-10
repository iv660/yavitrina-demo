<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\validators\EmailOrPhoneValidator;
use app\components\validators\PhoneValidator;

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
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', EmailOrPhoneValidator::className()],
            ['username', 'filter', 'filter' => [$this, 'normalizePhone']],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => \Yii::t('app', 'This username has already been taken.')],
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
     * Checks if the username field is a valid phone number.
     */
    protected function isPhone()
    {
        $validator = new PhoneValidator();
        
        return $validator->validate($this->username);
    }
    
    /**
     * Converts the phone number to the uniform format: +xxxxxxxxxxx.
     * 
     * @param string $number
     * @return string
     */
    public function normalizePhone($number)
    {
        if ($this->isPhone()) {
            $result = preg_replace('/[-\.\s\(\)]/', '', $number);
        }
        
        return $result;
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