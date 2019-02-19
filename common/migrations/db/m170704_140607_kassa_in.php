<?php

use yii\db\Migration;

class m170704_140607_kassa_in extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%kassa_in}}', [
            'id' => $this->primaryKey(),
            'sum' => $this->integer()->comment('Сумма'),
            'type_id' => $this->integer(1)->comment('Тип'),
            'status' => $this->integer()->comment('Статус'),
            'user_id' => $this->integer()->comment('Менеджер'),
            'employee_id' => $this->integer()->comment('Сотрудник'),
            'dog_id' => $this->integer()->comment('Договор'),
            'company_id' => $this->integer()->comment('Компания'),

            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Изменен'),
        ], $tableOptions);

        $this->addForeignKey('fk_kassa_in_company', '{{%kassa_in}}', 'company_id', '{{%company}}', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropTable('{{%kassa_in}}');
    }
}
