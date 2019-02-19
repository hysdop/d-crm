<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 10.05.17
 * Time: 16:42
 */

namespace common\repositories;


use common\models\Directories;
use yii\behaviors\TimestampBehavior;

class DirectoriesRepository extends Directories
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 2;
    const STATUS_DELETED = 3;

    // Обращения
    const TYPE_COMING_ACTION = 1; // Планируемое действие
    const TYPE_COMING_SOURCE = 2; // Источник
    const TYPE_COMING_NATURE = 3; // Вид обращения
    const TYPE_COMING_BUY_FORECAST = 4; // Прогноз (купит/не купит)
    // Касса
    const TYPE_KASSA_IN = 5;

    static $statuses = [
        self::STATUS_ACTIVE => 'Активен',
        self::STATUS_DISABLED => 'Отключен',
        self::STATUS_DELETED => 'Удален'
    ];

    static $typesTree = [
        'Обращения' => [
            self::TYPE_COMING_ACTION => 'Планируемое действие',
            self::TYPE_COMING_SOURCE => 'Источник',
            self::TYPE_COMING_NATURE => 'Вид обращения',
            self::TYPE_COMING_BUY_FORECAST => 'Тип клиента'
        ],
        'Касса' => [
            self::TYPE_KASSA_IN => 'Тип прихода',
        ],
    ];

    static $types = [
        self::TYPE_COMING_ACTION => 'Планируемое действие',
        self::TYPE_COMING_SOURCE => 'Источник',
        self::TYPE_COMING_NATURE => 'Вид обращения',
        self::TYPE_COMING_BUY_FORECAST => 'Тип клиента',
        self::TYPE_KASSA_IN => 'Тип прихода',
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
        return (array_key_exists($id, self::$statuses) ? self::$statuses[$id] : '<span style="color:red;">unknown</span>' );
    }

    public static function getStatusNameColored($id)
    {
        switch ($id) {
            case self::STATUS_ACTIVE:
                $html = '<span style="color:green;">' . self::$statuses[self::STATUS_ACTIVE] . '</span>';
                break;
            case self::STATUS_DISABLED:
                $html = '<span style="color:red;">' . self::$statuses[self::STATUS_DISABLED] . '</span>';
                break;
            case self::STATUS_DELETED:
                $html = '<span style="color:red;">' . self::$statuses[self::STATUS_DELETED] . '</span>';
                break;
            default:
                $html = '<span style="color:red;">unknown</span>';
        }
        return $html;
    }

    public static function getTypeName($id, $withSection = false)
    {
        if ($withSection) {
            $result = false;
            foreach (self::$typesTree as $key => $item) {
                if (array_key_exists($id, $item)) {
                    $result = $key . ' ➡ ' . self::$types[$id];
                    break;
                }
            }
        } else {
            $result = (array_key_exists($id, self::$types) ? self::$types[$id] : false);
        }

        if (!$result) $result = '<span style="color:red;">unknown</span>';
        return $result;
     }

    public static function getPossibleDirectories($type)
    {
        return self::find()
            ->where(['type' => $type])
            ->andWhere(['status' => self::STATUS_ACTIVE])
            ->orderBy(['sort' => SORT_ASC])
            ->asArray()
            ->all();
    }

    /**
     * Возвращает все системные справочники
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getOnlySystem()
    {
        return self::find()
            ->where(['company_id' => null])
            ->andWhere(['status' => self::STATUS_ACTIVE])
            ->asArray()
            ->all();
    }
}