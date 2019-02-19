<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 06.07.17
 * Time: 14:50
 */

namespace common\repositories;


use common\models\Office;
use yii\behaviors\TimestampBehavior;

class OfficeRepository extends Office
{
    const TYPE_OWN = 1;
    const TYPE_LEASE = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    static $statuses = [
        self::STATUS_ACTIVE => 'Активен',
        self::STATUS_DELETED => 'Удален'
    ];

    static $types = [
        self::TYPE_LEASE => 'Аренда',
        self::TYPE_OWN => 'Собственный',
    ];

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function getTypeName($id)
    {
        if (isset(self::$types[$id]))
            return self::$types[$id];

        return 'unknown';
    }

    public static function getStatusName($id)
    {
        return (array_key_exists($id, self::$statuses) ? self::$statuses[$id] : '<span style="color:red;">unknown</span>');
    }
}