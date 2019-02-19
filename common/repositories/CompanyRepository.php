<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 04.05.17
 * Time: 17:20
 */

namespace common\repositories;

use common\models\Address;
use common\models\Company;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;

class CompanyRepository extends Company
{
    const TYPE_OOO = 1;
    const TYPE_IP = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;
    const STATUS_BLOCKED = 3;

    static $TYPE_LIST = [
        self::TYPE_IP => 'ИП',
        self::TYPE_OOO => 'ООО'
    ];

    static $TYPE_LIST_FULL = [
        self::TYPE_IP => 'Индивидуальный предприниматель',
        self::TYPE_OOO => 'Общество с ограниченной ответственностью'
    ];

    static $statuses = [
        self::STATUS_ACTIVE => 'Активен',
        self::STATUS_DELETED => 'Удален',
        self::STATUS_BLOCKED => 'Заблокирован'
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasMany(Address::className(), ['obj_id' => 'id', 'type' => AddressRepository::TYPE_COMPANY]);
    }

    public static function getTypeName($type, $full = false)
    {
        if ($full) {
            if (array_key_exists($type, self::$TYPE_LIST)) {
                return self::$TYPE_LIST_FULL[$type];
            }
        } else {
            if (array_key_exists($type, self::$TYPE_LIST)) {
                return self::$TYPE_LIST[$type];
            }
        }

        return '<span style="color: red;">неизвестно</span>';
    }

    public static function getEmployeesInfo($companyId)
    {
        $result = [
            'count' => 0,
            'active' => 0
        ];
        $users = UserRepository::find()
            ->where(['company_id' => $companyId])
            ->asArray()
            ->all();

        foreach ($users as $item) {
            $result['count']++;
            if ($item['status'] == UserRepository::STATUS_ACTIVE) {
                $result['active']++;
            }
        }

        return $result;
    }

    public static function getEmployees($companyId)
    {
        return (new Query())
            ->select('p.*')
            ->from('{{%user_profile}} p')
            ->innerJoin('{{%user}} u', 'u.id = p.user_id')
            ->where(['u.status' => UserRepository::STATUS_ACTIVE])
            ->andWhere(['u.company_id' => $companyId])
            ->all();
    }

    public static function getOffices($companyId, $active = true)
    {
        $models = (new Query())
            ->select('o.*')
            ->from('{{%office}} o')
            ->where(['o.company_id' => $companyId]);

        if ($active) {
            $models->andWhere(['o.status' => OfficeRepository::STATUS_ACTIVE]);
        }

        return $models->all();
    }
}
