<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%kassa_in}}".
 *
 * @property integer $id
 * @property integer $sum
 * @property integer $type_id
 * @property integer $status
 * @property integer $user_id
 * @property integer $employee_id
 * @property integer $dog_id
 * @property integer $company_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Company $company
 */
class KassaIn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%kassa_in}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sum', 'type_id', 'status', 'user_id', 'employee_id', 'dog_id', 'company_id', 'created_at', 'updated_at'], 'integer'],
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
            'sum' => 'Сумма',
            'type_id' => 'Тип',
            'status' => 'Статус',
            'user_id' => 'Менеджер',
            'employee_id' => 'Сотрудник',
            'dog_id' => 'Договор',
            'company_id' => 'Компания',
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
}
