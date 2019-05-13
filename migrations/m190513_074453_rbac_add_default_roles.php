<?php

use yii\db\Migration;
use app\models\User;

/**
 * Class m190513_074453_rbac_add_default_roles
 */
class m190513_074453_rbac_add_default_roles extends Migration
{
//    /**
//     * {@inheritdoc}
//     */
//    public function safeUp()
//    {
//
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function safeDown()
//    {
//        echo "m190513_074453_rbac_add_default_roles cannot be reverted.\n";
//
//        return false;
//    }

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $auth = Yii::$app->authManager;
        
        // Creating admin and editor roles
        $admin = $auth->createRole('admin');
        if (!$admin) {
            echo('Cannot create the admin role.');
            return false;
        }
        $manager = $auth->createRole('manager');
        if (!$manager) {
            echo('Cannot create the manager role.');
            return false;
        }
        $user = $auth->createRole('user');
        if (!$manager) {
            echo('Cannot create the user role.');
            return false;
        }
        
        // Saving roles
        if (!$auth->add($admin)) {
            echo('Cannot store the admin role.');
            return false;
        }
        if (!$auth->add($manager)) {
            echo('Cannot store the manager role.');
            return false;
        }
        if (!$auth->add($user)) {
            echo('Cannot store the user role.');
            return false;
        }
        
        // Creating permissions
        // NOTE:    Permissions are disabled for the purposes of demonstration.
        //          The disabled lines below are provided as an example of
        //          possible assignments.
//        $viewAdminPage = $auth->createPermission('viewAdminPage');
//        $viewAdminPage->description = 'Доступ к панели администратора';
//        
//        $updateNews = $auth->createPermission('updateNews');
//        $updateNews->description = 'Редактирование новостей';
//        
//        // Saving permissions
//        $auth->add($viewAdminPage);
//        $auth->add($updateNews);
        
        // Creating inheritance
        // Assigning Manager's permissions
//        $auth->addChild($manager, $updateNews);

        // Manager inherits permissions from User
        if (!$auth->addChild($manager, $user)) {
            echo('Cannot add roles inheritance.');
            return false;
        }
        // Admin inherits permissions from Manager
        if (!$auth->addChild($admin, $manager)) {
            echo('Cannot add roles inheritance.');
            return false;
        }
        
        // Assigning Admin's permissions
//        $auth->addChild($admin, $viewAdminPage);
        // 

        // Assigning Admin role to the user with ID = 1
        if (!$auth->assign($admin, 1)) {
            echo('Cannot assign the admin role to a user.');
            return false;
        }
        
        // Assigning Manager role to the user with ID = 2
        if(!$auth->assign($manager, 2)) {
            echo('Cannot assign the manager role to a user.');
            return false;
        }
    }

    public function down()
    {
        $auth = Yii::$app->authManager;
        
        // Retrieving admin and editor roles
        $admin = $auth->getRole('admin');
        if (!$admin) {
            echo('Cannot load the admin role.');
            return false;
        }
        $manager = $auth->getRole('manager');
        if (!$manager) {
            echo('Cannot load the manager role.');
            return false;
        }
        $user = $auth->getRole('user');
        if (!$manager) {
            echo('Cannot load the user role.');
            return false;
        }
        
        // Removing roles
        if (!$auth->remove($admin)) {
            echo('Cannot remove the admin role.');
            return false;
        }
        if (!$auth->remove($manager)) {
            echo('Cannot remove the manager role.');
            return false;
        }
        if (!$auth->remove($user)) {
            echo('Cannot remove the user role.');
            return false;
        }
    }
}
