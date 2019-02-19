<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 15.05.17
 * Time: 10:01
 */

namespace common\repositories;


use common\models\Comings;
use yii\behaviors\TimestampBehavior;

class ComingsRepository extends Comings
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    const SEX_MALE = false;
    const SEX_FEMALE = true;

    static $statuses = [
        self::STATUS_ACTIVE => 'Активен',
        self::STATUS_DELETED => 'Удален'
    ];

    static $sexList = [
        self::SEX_MALE => 'Муж.',
        self::SEX_FEMALE => 'Жен.'
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'buy_forecast_id' => 'Тип клиента',
            'user_id' => 'Менеджер'
        ]);
    }

    public static function getStatusName($id)
    {
        return (array_key_exists($id, self::$statuses) ? self::$statuses[$id] : '<span style="color:red;">unknown</span>');
    }
}