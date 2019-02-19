<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 30.05.17
 * Time: 10:48
 */

namespace common\repositories;


use common\models\Clients;
use yii\behaviors\TimestampBehavior;

class ClientsRepository extends Clients
{
    const TYPE_FIZ = 1;
    const TYPE_UR = 2;

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

    static $types = [
        self::TYPE_FIZ => 'Физ. лицо',
        self::TYPE_UR => 'Юр. лицо'
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

    public static function getStatusName($id)
    {
        return (array_key_exists($id, self::$statuses) ? self::$statuses[$id] : '<span style="color:red;">unknown</span>');
    }

    public static function getTypeName($id)
    {
        return (array_key_exists($id, self::$types) ? self::$types[$id] : '<span style="color:red;">unknown</span>');
    }

    public static function getSexName($id)
    {
        return (array_key_exists($id, self::$sexList) ? self::$sexList[$id] : '<span style="color:red;">unknown</span>');
    }
}