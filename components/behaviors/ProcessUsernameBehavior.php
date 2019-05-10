<?php
namespace app\components\behaviors;

use yii\base\Behavior;
use app\components\validators\PhoneValidator;

/**
 * Behavior for user name processing.
 *
 * @author Ilya Vikharev
 */
class ProcessUsernameBehavior extends Behavior
{
    /**
     * Checks if the username field is a valid phone number.
     */
    protected function isPhone()
    {
        $validator = new PhoneValidator();
        
        return $validator->validate($this->owner->username);
    }
    
    /**
     * Transforms the phone number to the uniform format: +xxxxxxxxxxx.
     * 
     * @param string $number
     * @return string
     */
    public function normalizePhone($number)
    {
        $result = $number;
        
        if ($this->isPhone()) {
            $result = preg_replace('/[-\.\s\(\)]/', '', $result);
        }
        
        return $result;
    }
}
