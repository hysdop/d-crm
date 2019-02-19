<?php

use yii\db\Migration;

class m170515_124539_phones extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%phones}}', [
            'id' => $this->primaryKey(),
            'phone' => $this->char(10)->comment('Телефон'),
            'type' => $this->smallInteger(1)->comment('Тип'),
            'obj_id' => $this->integer()->comment('Объёкт'),
            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Изменен'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%phones}}');
    }
}
