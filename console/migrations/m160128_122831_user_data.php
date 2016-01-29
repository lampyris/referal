<?php

use yii\db\Schema;
use yii\db\Migration;

class m160128_122831_user_data extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'administrator',
            'email' => 'administrator@refer.ru',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('administrator'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time()
        ]);
        $this->insert('{{%user}}', [
            'id' => 2,
            'username' => 'user',
            'email' => 'user@refer.ru',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('user'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time()
        ]);
    }

    public function safeDown()
    {
        $this->delete('{{%user}}', [
            'id' => [1, 2]
        ]);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
