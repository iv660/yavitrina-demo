<?php
/**
 * @copyright Copyright (c) 2019 Ilya Vikharev
 */

namespace app\components\validators;

use yii\validators\Validator;

/**
 * EmailOrPhoneValidator validates that the attribute value is either a valid 
 * email address or a valid phone number.
 *
 * @author Ilya Vikharev <iv660@yandex.ru>
 */
class PhoneValidator extends Validator
{
    /**
     * @var string the regular expression used to validate the attribute value.
     */
    public $pattern = '/^\+\s*\d+[\s-\.]*\(?[\s-\.]*\d+[\s-\.]*\)?[\s-\.]*[\d\s-\.]+$/';
    
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        
        if ($this->message === null) {
            $this->message = \Yii::t('app', '{attribute} is not a valid email address or phone number.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateValue($value)
    {
        // Validate as Email first, then check against the phone rules
        if (!$this->validatePhone($value)) {
            return [$this->message, []];
        } else {
            return null;
        }
    }
    
    /**
     * Check if the value is a valid phone number.
     * 
     * @param type $value
     * @return boolean
     */
    protected function validatePhone($value)
    {
        return preg_match($this->pattern, $value);
    }
}
