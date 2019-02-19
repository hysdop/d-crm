<?php

use yii\db\Migration;

class m170425_085044_messages extends Migration
{
    public function up()
    {
        $this->createTable('{{%dialogs_messages}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('Пользователь'),
            'dialog_id' => $this->integer()->notNull()->comment('Диалог'),
            'read_at' => $this->integer()->null()->comment('Прочитан'),
            'ip' => $this->integer()->unsigned()->comment('IP'),
            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Изменен'),
            'text' => $this->string(1024)->comment('Текст'),
        ]);

        $this->addForeignKey('fk_dialogs_messages_user_id',   '{{%dialogs_messages}}', 'user_id',   '{{%user}}',    'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_dialogs_messages_dialog_id', '{{%dialogs_messages}}', 'dialog_id', '{{%dialogs}}', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropTable('{{%dialogs_messages}}');
    }
}
