<?php
namespace app\components\behaviors;

use yii\base\Behavior;
use app\components\validators\PhoneValidator;

/**
 * Behavior to generate passwords.
 *
 * @author Ilya Vikharev
 */
class PasswordGeneratorBehavior extends Behavior
{
    /**
     * Generates user password.
     * 
     * For the purposes of this demonstration, the hard-coded 'user' password is 
     * used for every new user.
     * 
     * @return string
     */
    public function generatePassword()
    {
        if (!$this->owner->password) {
            $this->owner->password = 'user'; // For production, use: Yii::$app->security->generateRandomString(6)
        }
        
        return $this->owner->password;
    }
}
