<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comings".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property integer $source_id
 * @property integer $type_id
 * @property string $birthday
 * @property integer $status
 * @property string $phone
 * @property integer $constructions
 * @property string $expected_order_date
 * @property integer $user_id
 * @property integer $expected_action_id
 * @property string $expected_action_date
 * @property integer $sex
 * @property integer $buy_forecast_id
 * @property string $comment_user
 * @property string $comment_client
 * @property integer $client_id
 * @property integer $company_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Clients $client
 * @property Company $company
 */
class Comings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'type_id', 'status', 'constructions', 'user_id', 'expected_action_id', 'sex', 'buy_forecast_id', 'client_id', 'company_id', 'created_at', 'updated_at'], 'integer'],
            [['birthday', 'expected_order_date', 'expected_action_date'], 'safe'],
            [['firstname', 'lastname', 'middlename', 'phone', 'comment_user', 'comment_client'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
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
            'source_id' => 'Источник',
            'type_id' => 'Тип обращения',
            'birthday' => 'Дата рождения',
            'status' => 'Статус',
            'phone' => 'Телефон',
            'constructions' => 'Количество конструкций',
            'expected_order_date' => 'Ожидаемая дата заказа',
            'user_id' => 'Пользователь',
            'expected_action_id' => 'Запланированное действие',
            'expected_action_date' => 'Дата действия',
            'sex' => 'Пол',
            'buy_forecast_id' => 'Прогноз',
            'comment_user' => 'Комментарий менеджера',
            'comment_client' => 'Комментарий клиента',
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
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
