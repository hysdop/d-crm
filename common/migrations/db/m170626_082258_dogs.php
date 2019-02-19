<?php

use yii\db\Migration;

class m170626_082258_dogs extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%dogs}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string()->comment('Имя'),
            'lastname' => $this->string()->comment('Фамилия'),
            'middlename' => $this->string()->comment('Отчество'),
            'sum' => $this->integer()->comment('Сумма'),
            'discount' => $this->float()->comment('Скидка'),
            'type' => $this->integer(1)->comment('Тип клиента'),
            'status' => $this->integer()->comment('Статус'),
            'text' => $this->text()->comment('Примечание'),
            'from' => $this->smallInteger()->comment('Создан из'),
            'from_id' => $this->integer()->comment('Создан из'),
            'user_id' => $this->integer()->comment('Менеджер'),
            'company_id' => $this->integer()->comment('Компания'),
            'client_id'  => $this->integer()->comment('Клиент'),
            'address_id' => $this->integer()->comment('Адрес'),
            'measurement_id' => $this->integer()->comment('Замер'),

            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Изменен'),
        ], $tableOptions);

        $this->addForeignKey('fk_dogs_measurement_id', '{{%dogs}}', 'measurement_id', '{{%measurements}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_dogs_user_id', '{{%dogs}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_dogs_clients', '{{%dogs}}', 'client_id', '{{%clients}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_dogs_address', '{{%dogs}}', 'address_id', '{{%address}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_dogs_company', '{{%dogs}}', 'company_id', '{{%company}}', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropTable('{{%dogs}}');
    }
}
