<?php

use yii\db\Migration;

class m170613_074408_measurements extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%measurements}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string()->comment('Имя'),
            'lastname' => $this->string()->comment('Фамилия'),
            'middlename' => $this->string()->comment('Отчество'),
            'status' => $this->integer()->comment('Статус'),
            'date' => $this->date()->comment('Дата'),
            'time' => $this->time()->comment('Время'),
            'constructions' => $this->integer()->comment('Количество конструкций'),
            'from' => $this->smallInteger()->comment('Создан из'),
            'from_id' => $this->integer()->comment('Создан из'),
            'user_id' => $this->integer()->comment('Пользователь'),
            'employee_id' => $this->integer()->comment('Сотрудник'),
            'address_id' => $this->integer()->comment('Адрес'),
            'client_id' => $this->integer()->comment('Клиент'),
            'company_id' => $this->integer()->comment('Компания'),
            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Изменен'),
        ], $tableOptions);

        $this->addForeignKey('fk_measurements_employee', '{{%measurements}}', 'employee_id', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_clients_measurements', '{{%measurements}}', 'client_id', '{{%clients}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_measurements_address', '{{%measurements}}', 'address_id', '{{%address}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_measurements_company', '{{%measurements}}', 'company_id', '{{%company}}', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropTable('{{%measurements}}');
    }
}
