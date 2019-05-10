<?php

use yii\db\Migration;
use app\models\User;

/**
 * Class m190510_080600_create_default_users
 */
class m190510_080600_create_default_users extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $model = User::find()->where(['username' => 'admin@example.com'])->one();
        if (empty($model)) {
            $user = new User();
            $user->username = 'admin@example.com';
            $user->setPassword('admin');
            $user->generateAuthKey();
            if ($user->save()) {
                echo "admin@example.com creatiion: OK\n";
            } else {
                "admin@example.com creation: failed\n";
                return false;
            }
        }
        
        $model = User::find()->where(['username' => 'demo@example.com'])->one();
        if (empty($model)) {
            $user = new User();
            $user->username = 'demo@example.com';
            $user->setPassword('demo');
            $user->generateAuthKey();
            if ($user->save()) {
                echo "demo@example.com creatiion: OK\n";
            } else {
                "demo@example.com creation: failed\n";
                return false;
            }
        }
    }

    public function down()
    {
        $this->delete('{{%user}}', "username='admin' OR username='demo'");
    }
}
