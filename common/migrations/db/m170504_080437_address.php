<?php

use yii\db\Migration;

class m170504_080437_address extends Migration
{
    public function up()
    {
        $this->createTable('{{%address}}', [
            'id'         => $this->primaryKey(),
            'region_id' => $this->char(36)->comment('Регион'),
            'city_id' => $this->char(36)->comment('Город'),
            'settlement_id' => $this->char(36)->comment('Село'),
            'street_id' => $this->char(36)->comment('Улица'),
            'house_id' => $this->char(36)->comment('Дом'),
            'postal_code' => $this->string(10)->comment('Почтовый индекс'),
            'full' => $this->string()->comment('Адрес'),
            'type' => $this->smallInteger(1)->comment('Тип'),
            'obj_id' => $this->integer()->comment('Объёкт'),
            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Изменен'),
        ]);

        $this->createIndex('obj_id_type_index', '{{%address}}', ['type', 'obj_id']);
    }

    public function down()
    {
        $this->dropTable('{{%address}}');
    }
}
