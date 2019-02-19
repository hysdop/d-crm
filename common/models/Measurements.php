<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%measurements}}".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property integer $status
 * @property string $date
 * @property string $time
 * @property integer $constructions
 * @property integer $from
 * @property integer $from_id
 * @property integer $user_id
 * @property integer $employee_id
 * @property integer $address_id
 * @property integer $client_id
 * @property integer $company_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Clients $client
 * @property Address $address
 * @property Company $company
 * @property User $employee
 */
class Measurements extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%measurements}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'constructions', 'from', 'from_id', 'user_id', 'employee_id', 'address_id', 'client_id', 'company_id', 'created_at', 'updated_at'], 'integer'],
            [['date', 'time'], 'safe'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['employee_id' => 'id']],
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
            'status' => 'Статус',
            'date' => 'Дата',
            'time' => 'Время',
            'constructions' => 'Количество конструкций',
            'from' => 'Создан из',
            'from_id' => 'Создан из',
            'user_id' => 'Пользователь',
            'employee_id' => 'Сотрудник',
            'address_id' => 'Адрес',
            'client_id' => 'Клиент',
            'company_id' => 'Компания',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
        ];
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
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
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
    public function getEmployee()
    {
        return $this->hasOne(User::className(), ['id' => 'employee_id']);
    }
}
