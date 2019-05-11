<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\validators\EmailOrPhoneValidator;
use app\components\validators\PhoneValidator;
use app\components\behaviors\ProcessUsernameBehavior;
use app\models\User;

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
    public function behaviors()
    {
        return [
            'processUsername' => ProcessUsernameBehavior::ClassName(),
        ];
    }

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
    
    public function notify() 
    {
        if ($this->isPhone()) {
            // Notify by SMS
            
        } else {
            // Notify by email
            $user = User::find()->where(['username' => $this->username])->one();
            $user->generateVerificationToken();
            if ($user->save()) {
                $mail = Yii::$app->mailer->compose('notify', ['model' => $user])
                        ->setFrom('mail@example.com')
                        ->setTo($user->username)
                        ->setSubject('Complete Your Registration')
                        ->send();
                var_dump($mail);
            }
        }
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
        if (!$this->isPhone()) {
            $user->status = User::STATUS_DISABLED;
        }
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}