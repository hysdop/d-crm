<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $region_id
 * @property string $city_id
 * @property string $street_id
 * @property string $house_id
 * @property string $house
 * @property string $postal_code
 * @property string $full
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Company[] $companies
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['region_id', 'city_id', 'street_id', 'house_id'], 'string', 'max' => 36],
            [['house', 'postal_code'], 'string', 'max' => 10],
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
            'region_id' => 'Region ID',
            'city_id' => 'City ID',
            'street_id' => 'Street ID',
            'house_id' => 'House ID',
            'house' => 'House',
            'postal_code' => 'Postal Code',
            'full' => 'Full',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['address_id' => 'id']);
    }
}
