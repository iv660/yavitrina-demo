<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%auth}}".
 *
 * @property int $user_id
 * @property string $source
 * @property string $source_id
 */
class Auth extends \yii\db\ActiveRecord
{
    /**
     * @property \app\models\User $user
     */
    private $user = null;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%auth}}';
    }
    
    /**
     * 
     */
    public function getUser() 
    {
        if (!$this->user and $this->user_id) {
            $this->user = User::findIdentity($this->user_id);
        }
        
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source', 'source_id'], 'string', 'max' => 255],
            [['source', 'source_id'], 'unique', 'targetAttribute' => ['source', 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'source' => 'Source',
            'source_id' => 'Source ID',
        ];
    }
}
