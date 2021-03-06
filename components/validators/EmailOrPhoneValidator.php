<?php
/**
 * @copyright Copyright (c) 2019 Ilya Vikharev
 */

namespace app\components\validators;

use yii\validators\Validator;
use yii\validators\EmailValidator;
use app\components\validators\PhoneValidator;

/**
 * EmailOrPhoneValidator validates that the attribute value is either a valid 
 * email address or a valid phone number.
 *
 * @author Ilya Vikharev <iv660@yandex.ru>
 */
class EmailOrPhoneValidator extends Validator
{
    /**
     * @var string the regular expression used to validate the attribute value.
     */
    
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        
        if ($this->message === null) {
            $this->message = \Yii::t('app', '{attribute} is not a valid email address or international phone number.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateValue($value)
    {
        $emailValidator = new EmailValidator();
        $phoneValidator = new PhoneValidator();
        // Validate as Email first, then check against the phone rules
        if (!($emailValidator->validate($value, $error) || $phoneValidator->validate($value))) {
            return [$this->message, []];
        } else {
            return null;
        }
    }
}
