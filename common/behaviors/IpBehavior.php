<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 14.06.17
 * Time: 10:54
 */

namespace common\behaviors;


use yii\base\Event;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;
use Yii;

class IpBehavior extends AttributeBehavior
{
    public $attributes = [
        BaseActiveRecord::EVENT_BEFORE_INSERT => 'ip'
    ];


    /**
     * Назначаем обработчик для [[owner]] событий
     * @return array события (array keys) с назначеными им обработчиками (array values)
     */
    public function events()
    {
        $events = $this->attributes;
        foreach ($events as $i => $event) {
            $events[$i] = 'getCurrentIp';
        }
        return $events;
    }


    /**
     * Добавляем IP адрес
     * @param Event $event Текущее событие
     */
    public function getCurrentIp($event)
    {
        $attributes = isset($this->attributes[$event->name]) ? (array)$this->attributes[$event->name] : [];

        if (!empty($attributes)) {
            $ip = ip2long(Yii::$app->request->userIP);
            foreach($attributes as $source => $attribute) {
                $this->owner->$attribute = $ip;
            }
        }
    }
}