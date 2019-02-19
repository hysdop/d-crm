<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%clients_requisites}}".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $ogrn
 * @property string $inn
 * @property string $kpp
 * @property string $okpo
 * @property string $ras
 * @property string $corr_account
 * @property string $bik
 * @property string $bank
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Clients $client
 */
class ClientsRequisites extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%clients_requisites}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'created_at', 'updated_at'], 'integer'],
            [['ogrn'], 'string', 'max' => 15],
            [['inn'], 'string', 'max' => 12],
            [['kpp', 'bik'], 'string', 'max' => 9],
            [['okpo'], 'string', 'max' => 10],
            [['ras', 'corr_account'], 'string', 'max' => 20],
            [['bank'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Клиент',
            'ogrn' => 'ОГРН',
            'inn' => 'ИНН',
            'kpp' => 'КПП',
            'okpo' => 'ОКПО',
            'ras' => 'Расчетный счет',
            'corr_account' => 'Корр. счет',
            'bik' => 'БИК',
            'bank' => 'Банк',
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
}
