<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 13.06.17
 * Time: 16:29
 */

namespace common\repositories;


use common\models\Measurements;
use yii\behaviors\TimestampBehavior;
use common\components\Icons;

class MeasurementsRepository extends Measurements
{
    const FROM_COMING = 1;
    const FROM_CLIENT = 2;

    const STATUS_PLANNED = 3;
    const STATUS_REFUSED = 4;
    const STATUS_MOVED = 5;
    const STATUS_WAITING = 6;
    const STATUS_CANCEL = 7;

    static $statuses = [
        self::STATUS_PLANNED => 'Планируется',
        self::STATUS_REFUSED => 'Отказ',
        self::STATUS_MOVED => 'Перенесен',
        self::STATUS_WAITING => 'Ожидание',
        self::STATUS_CANCEL => 'Аннулирован'
    ];

    static $statusWithIcon = null;

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

    public static function getStatusNameWithIcon($id)
    {
        if (self::$statusWithIcon === null) {
            self::$statusWithIcon[self::STATUS_PLANNED] = Icons::get(Icons::TIMER, 'lime') . ' ' . self::getStatusName(self::STATUS_PLANNED);
            self::$statusWithIcon[self::STATUS_REFUSED] = Icons::get(Icons::CANCEL, 'red') . ' ' . self::getStatusName(self::STATUS_REFUSED);
            self::$statusWithIcon[self::STATUS_MOVED] = Icons::get(Icons::MOVED, 'gray') . ' ' . self::getStatusName(self::STATUS_MOVED);
            self::$statusWithIcon[self::STATUS_WAITING] = Icons::get(Icons::WAIT, 'orange') . ' ' . self::getStatusName(self::STATUS_WAITING);
            self::$statusWithIcon[self::STATUS_CANCEL] = Icons::get(Icons::CANCEL, 'red') . ' ' . self::getStatusName(self::STATUS_CANCEL);
        }

        return (array_key_exists($id, self::$statusWithIcon) ? self::$statusWithIcon[$id] : '<span style="color:red;">unknown</span>');
    }
}