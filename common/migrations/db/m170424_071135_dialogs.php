<?php

use yii\db\Migration;

class m170424_071135_dialogs extends Migration
{
    public function up()
    {
        $this->createTable('{{%dialogs}}', [
            'id' => $this->primaryKey(),
            'user_1' => $this->integer()->notNull()->comment('Пользователь 1'),
            'user_2' => $this->integer()->notNull()->comment('Пользователь 2'),
            'status' => $this->integer(2)->null()->comment('Прочитан'),
            'ip' => $this->integer()->unsigned()->comment('IP'),
            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Изменен'),
        ]);

        $this->addForeignKey('fk_messages_user_1', '{{%dialogs}}', 'user_1', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_messages_user_2', '{{%dialogs}}', 'user_2', '{{%user}}', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropTable('{{%dialogs}}');
    }
}
