<?php

use yii\db\Migration;

class m170510_133442_directories extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%directories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('Название'),
            'type' => $this->integer(2)->comment('Тип'),
            'status' => $this->integer(1)->comment('Статус'),
            'sort' => $this->integer()->comment('Сортировка'),
            'company_id' => $this->integer()->comment('Компания'),
            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Изменен'),
        ], $tableOptions);

        $this->addForeignKey('fk_company', '{{%directories}}', 'company_id', '{{%company}}', 'id', 'restrict', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_company', '{{%directories}}');
        $this->dropTable('{{%directories}}');
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
