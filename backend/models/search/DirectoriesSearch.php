<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\repositories\DirectoriesRepository;

/**
 * DirectoriesSearch represents the model behind the search form about `common\repositories\DirectoriesRepository`.
 */
class DirectoriesSearch extends DirectoriesRepository
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'sort', 'type', 'company_id'], 'integer'],
            [['name', 'created_at'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DirectoriesRepository::find()
            ->where(['company_id' => null])
            ->andWhere(['status' => [
                DirectoriesRepository::STATUS_ACTIVE,
                DirectoriesRepository::STATUS_DISABLED
            ]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'sort' => $this->sort,
            'type' => $this->type,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['from_unixtime(created_at, \'%Y-%m-%d\')' => $this->created_at]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
