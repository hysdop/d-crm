<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%clients}}".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property integer $type
 * @property integer $sex
 * @property string $birthday
 * @property integer $status
 * @property integer $user_id
 * @property string $text
 * @property integer $company_id
 * @property integer $passport_series
 * @property integer $passport_number
 * @property string $passport_date
 * @property string $passport_issue
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Company $company
 * @property ClientsRequisites[] $clientsRequisites
 * @property Comings[] $comings
 * @property Dogs[] $dogs
 * @property Measurements[] $measurements
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%clients}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'sex', 'status', 'user_id', 'company_id', 'passport_series', 'passport_number', 'created_at', 'updated_at'], 'integer'],
            [['birthday', 'passport_date'], 'safe'],
            [['text'], 'string'],
            [['firstname', 'lastname', 'middlename', 'passport_issue'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
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
            'type' => 'Тип клиента',
            'sex' => 'Пол',
            'birthday' => 'Дата рождения',
            'status' => 'Статус',
            'user_id' => 'Менеджер',
            'text' => 'Примечание',
            'company_id' => 'Компания',
            'passport_series' => 'Серия',
            'passport_number' => 'Номер',
            'passport_date' => 'Дата выдачи',
            'passport_issue' => 'Кем выдан',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
        ];
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
    public function getClientsRequisites()
    {
        return $this->hasMany(ClientsRequisites::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComings()
    {
        return $this->hasMany(Comings::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDogs()
    {
        return $this->hasMany(Dogs::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeasurements()
    {
        return $this->hasMany(Measurements::className(), ['client_id' => 'id']);
    }
}
