<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\validators\EmailOrPhoneValidator;
use app\components\behaviors\ProcessUsernameBehavior;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ActivateForm extends Model
{
    public $username;
    public $password;
    public $token = false;

    private $user = false;
    
    /**
     * @inheritdoc
     */
    public function load ($data, $formName = null)
    {
        // Load data the standard way first
        parent::load($data, $formName);
            
        if (!$this->token) {
            // Try loading the token from a query parameter
            $this->token = Yii::$app->request->get('token');
        }
        
        if (!$this->token) {
            // Cannot load the token
            return false;
        }
        
        return true;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // The password is required
            ['password', 'required'],
        ];
    }

    /**
     * Sets the password.
     * 
     * @return boolean False on error
     */
    public function setPassword()
    {
        if ($this->hasErrors() or !$this->password) {
            return false;
        }
        
        $user = $this->getUser();

        $user->setPassword($this->password);
        $user->verification_token = null;
        $user->status = User::STATUS_ACTIVE;
        
        if(!$user->save()) {
            return false;
        }
        
        return true;
    }

    /**
     * Finds user by [[verification token]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user === false) {
            $this->user = User::findByVerificationToken($this->token);
            if (!$this->user) {
                $this->addError(Yii::t('app', 'Invalid verification code.'));
            }
        }

        return $this->user;
    }
}
