<?php

use yii\db\Migration;
use \common\repositories\DirectoriesRepository;

class m170516_143225_fill_directories extends Migration
{
    public function up()
    {
        // Обращения
        $this->insert('{{%directories}}', [
            'name' => 'Визит в офис',
            'status' => DirectoriesRepository::STATUS_ACTIVE,
            'type' => DirectoriesRepository::TYPE_COMING_ACTION,
        ]);
        $this->insert('{{%directories}}', [
            'name' => 'Звонок',
            'status' => DirectoriesRepository::STATUS_ACTIVE,
            'type' => DirectoriesRepository::TYPE_COMING_ACTION,
        ]);
        $this->insert('{{%directories}}', [
            'name' => 'Проведение замера',
            'status' => DirectoriesRepository::STATUS_ACTIVE,
            'type' => DirectoriesRepository::TYPE_COMING_ACTION,
        ]);
        $this->insert('{{%directories}}', [
            'name' => 'Подписание договора',
            'status' => DirectoriesRepository::STATUS_ACTIVE,
            'type' => DirectoriesRepository::TYPE_COMING_ACTION,
        ]);

        $this->insert('{{%directories}}', [
            'name' => 'Интернет',
            'status' => DirectoriesRepository::STATUS_ACTIVE,
            'type' => DirectoriesRepository::TYPE_COMING_SOURCE,
        ]);
        $this->insert('{{%directories}}', [
            'name' => 'Банер',
            'status' => DirectoriesRepository::STATUS_ACTIVE,
            'type' => DirectoriesRepository::TYPE_COMING_SOURCE,
        ]);

        $this->insert('{{%directories}}', [
            'name' => 'Посещение',
            'status' => DirectoriesRepository::STATUS_ACTIVE,
            'type' => DirectoriesRepository::TYPE_COMING_NATURE,
        ]);
        $this->insert('{{%directories}}', [
            'name' => 'Звонок',
            'status' => DirectoriesRepository::STATUS_ACTIVE,
            'type' => DirectoriesRepository::TYPE_COMING_NATURE,
        ]);

        $this->insert('{{%directories}}', [
            'name' => 'Хочет и может купить',
            'status' => DirectoriesRepository::STATUS_ACTIVE,
            'type' => DirectoriesRepository::TYPE_COMING_BUY_FORECAST,
        ]);
        $this->insert('{{%directories}}', [
            'name' => 'Хочет, но не может купить',
            'status' => DirectoriesRepository::STATUS_ACTIVE,
            'type' => DirectoriesRepository::TYPE_COMING_BUY_FORECAST,
        ]);
        $this->insert('{{%directories}}', [
            'name' => 'Не хочет, но может купить',
            'status' => DirectoriesRepository::STATUS_ACTIVE,
            'type' => DirectoriesRepository::TYPE_COMING_BUY_FORECAST,
        ]);
        $this->insert('{{%directories}}', [
            'name' => 'Не хочет и не может купить',
            'status' => DirectoriesRepository::STATUS_ACTIVE,
            'type' => DirectoriesRepository::TYPE_COMING_BUY_FORECAST,
        ]);

        // Касса
        $this->insert('{{%directories}}', [
            'name' => 'Поступление от клиента',
            'status' => DirectoriesRepository::STATUS_ACTIVE,
            'type' => DirectoriesRepository::TYPE_KASSA_IN,
        ]);
        $this->insert('{{%directories}}', [
            'name' => 'Прочий приход',
            'status' => DirectoriesRepository::STATUS_ACTIVE,
            'type' => DirectoriesRepository::TYPE_KASSA_IN,
        ]);
    }

    public function down()
    {
        $this->delete('{{%directories}}', ['name' => 'Визит в офис', 'type' => DirectoriesRepository::TYPE_COMING_ACTION]);
        $this->delete('{{%directories}}', ['name' => 'Звонок', 'type' => DirectoriesRepository::TYPE_COMING_ACTION]);
        $this->delete('{{%directories}}', ['name' => 'Проведение замера', 'type' => DirectoriesRepository::TYPE_COMING_ACTION]);
        $this->delete('{{%directories}}', ['name' => 'Подписание договора', 'type' => DirectoriesRepository::TYPE_COMING_ACTION]);

        $this->delete('{{%directories}}', ['name' => 'Банер',     'type' => DirectoriesRepository::TYPE_COMING_SOURCE]);
        $this->delete('{{%directories}}', ['name' => 'Интернет',  'type' => DirectoriesRepository::TYPE_COMING_SOURCE]);

        $this->delete('{{%directories}}', ['name' => 'Посещение', 'type' => DirectoriesRepository::TYPE_COMING_NATURE]);
        $this->delete('{{%directories}}', ['name' => 'Звонок',  'type' => DirectoriesRepository::TYPE_COMING_NATURE]);

        $this->delete('{{%directories}}', ['name' => 'Хочет и может купить', 'type' => DirectoriesRepository::TYPE_COMING_BUY_FORECAST]);
        $this->delete('{{%directories}}', ['name' => 'Хочет, но не может купить', 'type' => DirectoriesRepository::TYPE_COMING_BUY_FORECAST]);
        $this->delete('{{%directories}}', ['name' => 'Не хочет, но может купить', 'type' => DirectoriesRepository::TYPE_COMING_BUY_FORECAST]);
        $this->delete('{{%directories}}', ['name' => 'Не хочет и не может купить', 'type' => DirectoriesRepository::TYPE_COMING_BUY_FORECAST]);

        $this->delete('{{%directories}}', ['name' => 'Прочий приход', 'type' => DirectoriesRepository::TYPE_KASSA_IN]);
        $this->delete('{{%directories}}', ['name' => 'Поступление от клиента', 'type' => DirectoriesRepository::TYPE_KASSA_IN]);
    }
}