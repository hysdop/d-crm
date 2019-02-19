<?php

use yii\db\Migration;

class m170503_130624_company extends Migration
{
    public function up()
    {
        $this->createTable('{{%company}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(255)->comment('Название'),
            'phone'      => $this->string(11)->comment('Телефон'),
            'phone_second' => $this->string(11)->comment('Дополнительный телефон'),
            'type'       => $this->integer(1)->notNull()->comment('Форма организации'),
            //'address_id'    => $this->integer()->comment('Адрес'),
            'status' => $this->integer()->defaultValue(\common\repositories\CompanyRepository::STATUS_ACTIVE)->comment('Статус'),
            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Изменен'),
        ]);

        $this->addColumn('{{%user}}', 'company_id', 'integer');
        $this->addForeignKey('fk_user_company', '{{%user}}', 'company_id', '{{%company}}', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_user_company', '{{%user}}');
        $this->dropColumn('{{%user}}','company_id');

        $this->dropTable('{{%company}}');
    }
}