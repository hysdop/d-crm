<?php

use yii\db\Migration;

class m170513_132230_clients extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%clients}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string()->comment('Имя'),
            'lastname' => $this->string()->comment('Фамилия'),
            'middlename' => $this->string()->comment('Отчество'),
            'type' => $this->integer(1)->comment('Тип клиента'),
            'sex' => $this->boolean()->defaultValue(false)->comment('Пол'),
            'birthday' => $this->date()->comment('Дата рождения'),
            'status' => $this->integer()->comment('Статус'),
            'user_id' => $this->integer()->comment('Менеджер'),
            //'address_id' => $this->integer()->comment('Прописка'),
            'text' => $this->text()->comment('Примечание'),
            'company_id' => $this->integer()->comment('Компания'),

            'passport_series' => $this->integer(4)->comment('Серия'),
            'passport_number' => $this->integer(6)->comment('Номер'),
            'passport_date' => $this->date()->comment('Дата выдачи'),
            'passport_issue' => $this->string()->comment('Кем выдан'),

            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Изменен'),
        ], $tableOptions);

        $this->createTable('{{%clients_requisites}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->comment('Клиент'),
            'ogrn' => $this->char(15)->comment('ОГРН'),
            'inn' => $this->char(12)->comment('ИНН'),
            'kpp' => $this->char(9)->comment('КПП'),
            'okpo' => $this->char(10)->comment('ОКПО'),
            'ras' => $this->char(20)->comment('Расчетный счет'),
            'corr_account' => $this->char(20)->comment('Корр. счет'),
            'bik' => $this->char(9)->comment('БИК'),
            'bank' => $this->string()->comment('Банк'),
            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Изменен'),
        ], $tableOptions);

        $this->addForeignKey('fk_clients', '{{%clients_requisites}}', 'client_id', '{{%clients}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_clients_company', '{{%clients}}', 'company_id', '{{%company}}', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropTable('{{%clients_requisites}}');
        $this->dropTable('{{%clients}}');
    }
}
