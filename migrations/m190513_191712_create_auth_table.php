<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth}}`.
 */
class m190513_191712_create_auth_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%auth}}', [
            'user_id' => $this->integer(11),
            'source' => $this->string(255),
            'source_id' => $this->string(255),
        ], $tableOptions);
        $this->addPrimaryKey('{{%PK_source_user_id}}', '{{%auth}}', ['user_id', 'source']);
        $this->createIndex('{{%IX_source_user_id}}', '{{%auth}}', ['source_id', 'source'], true);
        $this->addForeignKey('{{%FK_auth_user_id_user_id}}', '{{%auth}}', ['user_id'], '{{%user}}', ['id'], 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auth}}');
    }
}
