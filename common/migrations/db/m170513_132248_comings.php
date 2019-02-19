<?php

use yii\db\Migration;

class m170513_132248_comings extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%comings}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string()->comment('Имя'),
            'lastname' => $this->string()->comment('Фамилия'),
            'middlename' => $this->string()->comment('Отчество'),
            'source_id' => $this->integer()->comment('Источник'),
            'type_id' => $this->integer()->comment('Тип обращения'),
            'birthday' => $this->date()->comment('Дата рождения'),
            'status' => $this->integer()->comment('Статус'),
            'phone' => $this->string()->comment('Телефон'),
            'constructions' => $this->integer()->comment('Количество конструкций'),
            'expected_order_date' => $this->date()->comment('Ожидаемая дата заказа'),
            'user_id' => $this->integer()->comment('Пользователь'),
            //'address_id' => $this->integer()->comment('Адрес'),
            'expected_action_id' => $this->integer()->comment('Запланированное действие'),
            'expected_action_date' => $this->dateTime()->comment('Дата действия'),
            'sex' => $this->boolean()->defaultValue(false)->comment('Пол'),
            'buy_forecast_id' => $this->integer()->comment('Прогноз'),
            'comment_user' => $this->string()->comment('Комментарий менеджера'),
            'comment_client' => $this->string()->comment('Комментарий клиента'),
            'client_id' => $this->integer()->comment('Клиент'),
            'company_id' => $this->integer()->comment('Компания'),
            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Изменен'),
        ], $tableOptions);

        $this->addForeignKey('fk_clients_comings', '{{%comings}}', 'client_id', '{{%clients}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_comings_company', '{{%comings}}', 'company_id', '{{%company}}', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropTable('{{%comings}}');
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
