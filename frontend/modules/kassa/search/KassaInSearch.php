<?php

namespace frontend\modules\kassa\search;

use common\repositories\DirectoriesRepository;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\repositories\KassaInRepository;
use yii\data\ArrayDataProvider;
use yii\db\Query;

/**
 * KassaInSearch represents the model behind the search form about `common\repositories\KassaInRepository`.
 */
class KassaInSearch extends KassaInRepository
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sum', 'type_id', 'status', 'user_id', 'employee_id', 'dog_id', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ArrayDataProvider
     */
    public function search($params)
    {

        $query = (new Query())
            ->select('k.*, dt.name typeName')
            ->from(KassaInRepository::tableName() . ' k')
            ->leftJoin(DirectoriesRepository::tableName() . ' dt', ['dt.id' => 'k.type'])
            ->where(['k.company_id' => Yii::$app->user->identity->company_id]);

        $this->load($params);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sum' => $this->sum,
            'type' => $this->type_id,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'employee_id' => $this->employee_id,
            'dog_id' => $this->dog_id,
            'created_at' => $this->created_at,
        ]);

        return new ArrayDataProvider([
            'allModels' => $query->all(),
            'key' => 'id'
        ]);
    }
}
