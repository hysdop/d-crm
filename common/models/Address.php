<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property integer $id
 * @property string $region_id
 * @property string $city_id
 * @property string $settlement_id
 * @property string $street_id
 * @property string $house_id
 * @property string $postal_code
 * @property string $full
 * @property integer $type
 * @property integer $obj_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'obj_id', 'created_at', 'updated_at'], 'integer'],
            [['region_id', 'city_id', 'settlement_id', 'street_id', 'house_id'], 'string', 'max' => 36],
            [['postal_code'], 'string', 'max' => 10],
            [['full'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Регион',
            'city_id' => 'Город',
            'settlement_id' => 'Село',
            'street_id' => 'Улица',
            'house_id' => 'Дом',
            'postal_code' => 'Почтовый индекс',
            'full' => 'Адрес',
            'type' => 'Тип',
            'obj_id' => 'Объёкт',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
        ];
    }
}
