<?php
namespace app\components;

use Yii;
use yii\base\Component;

/**
 * Send SMS notifications.
 *
 * @author Ilya Vikharev
 */
class Sms extends Component 
{
    public $apiId;
    public $gatewayEmail;
    protected $defaultGatewayEmail = '{{apiId}}+{{phone}}@sms.ru';
    
    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        
        if (!$this->gatewayEmail) {
            $this->gatewayEmail = $this->defaultGatewayEmail;
        }
    }
    
    /**
     * Populates the template with actual data.
     * 
     * @param string $template
     */
    protected function populate($template, $data) 
    {
        $result = $template;
        
        foreach ($data as $curKey => $curValue) {
            $result = str_replace('{{' . $curKey . '}}', $curValue, $result);
        }
        
        return $result;
    }
    
    /**
     * Removes the leading + sign.
     * 
     * @param string $phone The phone number to process
     * 
     * @return string Normalized phone number
     */
    public function normalizePhone($phone)
    {
        return str_replace('+', '', $phone);
    }
        

    /**
     * Send the message to the specified phone number.
     */
    public function send($phone, $message)
    {
        $data = [
            'apiId' => $this->apiId,
            'phone' => $this->normalizePhone($phone),
        ];
        
        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['senderEmail'])
            ->setTo($this->populate($this->gatewayEmail, $data))
            ->setTextBody($message)
            ->send();
    }
}
