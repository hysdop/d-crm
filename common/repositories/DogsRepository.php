<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 26.06.17
 * Time: 17:17
 */

namespace common\repositories;


use common\models\Dogs;
use yii\behaviors\TimestampBehavior;

class DogsRepository extends Dogs
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    const FROM_MEASUREMENT = 1;
    const FROM_CLIENT = 2;

    static $statuses = [
        self::STATUS_ACTIVE => 'Активен',
        self::STATUS_DELETED => 'Удален'
    ];

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public static function getStatusName($id)
    {
        if (array_key_exists($id, self::$statuses)) {
            $style = '';
            if (in_array($id, [self::STATUS_DELETED])) {
                $style = 'color: red;';
            }
            return '<span style="' . $style . '">' . self::$statuses[$id] . '</span>';
        } else {
            return '<span style="color:red;">unknown</span>';
        }
    }
}