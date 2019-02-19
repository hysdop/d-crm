<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%dogs}}".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property integer $sum
 * @property double $discount
 * @property integer $type
 * @property integer $status
 * @property string $text
 * @property integer $from
 * @property integer $from_id
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $client_id
 * @property integer $address_id
 * @property integer $measurement_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Address $address
 * @property Clients $client
 * @property Company $company
 * @property Measurements $measurement
 * @property User $user
 */
class Dogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dogs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sum', 'type', 'status', 'from', 'from_id', 'user_id', 'company_id', 'client_id', 'address_id', 'measurement_id', 'created_at', 'updated_at'], 'integer'],
            [['discount'], 'number'],
            [['text'], 'string'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 255],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['measurement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Measurements::className(), 'targetAttribute' => ['measurement_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
            'sum' => 'Сумма',
            'discount' => 'Скидка',
            'type' => 'Тип клиента',
            'status' => 'Статус',
            'text' => 'Примечание',
            'from' => 'Создан из',
            'from_id' => 'Создан из',
            'user_id' => 'Менеджер',
            'company_id' => 'Компания',
            'client_id' => 'Клиент',
            'address_id' => 'Адрес',
            'measurement_id' => 'Замер',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeasurement()
    {
        return $this->hasOne(Measurements::className(), ['id' => 'measurement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
