<?php

use yii\db\Migration;

class m170706_114058_office extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%office}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('Название'),
            'phone'      => $this->string(11)->comment('Телефон'),
            'phone_second' => $this->string(11)->comment('Дополнительный телефон'),
            'type' => $this->integer(1)->comment('Тип'),
            'status' => $this->integer()->comment('Статус'),
            'company_id' => $this->integer()->comment('Компания'),

            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Изменен'),
        ], $tableOptions);

        $this->addForeignKey('fk_office_company', '{{%office}}', 'company_id', '{{%company}}', 'id', 'cascade', 'cascade');

        $this->addColumn('{{%user}}', 'office_id', $this->integer()->comment('Оффис'));
        $this->addForeignKey('fk_user_office', '{{%user}}', 'office_id', '{{%office}}', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_user_office', '{{%user}}');
        $this->dropColumn('{{%user}}', 'office_id');

        $this->dropForeignKey('fk_office_company', '{{%office}}');

        $this->dropTable('{{%office}}');
    }
}
