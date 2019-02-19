<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%company_positions}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $created_by
 * @property integer $company_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class CompanyPositions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company_positions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created_by', 'company_id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_by' => 'Created By',
            'company_id' => 'Company ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
