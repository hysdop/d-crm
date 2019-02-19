<?php

namespace frontend\modules\settings\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\repositories\DirectoriesRepository;
use yii\data\ArrayDataProvider;
use yii\data\Sort;

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
            [['id', 'status', 'sort', 'type', 'company_id', 'system', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'safe'],
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
            ->where(['company_id' => Yii::$app->user->identity->company_id]);

        $this->load($params);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'company_id' => $this->company_id,
            'created_at' => $this->created_at,
        ]);

        if ($this->status) {
            $query->andWhere(['status' => $this->status]);
        } else {
            $query->andWhere(['<>', 'status', DirectoriesRepository::STATUS_DELETED]);
        }

        $query->andFilterWhere(['like', 'name', $this->name]);

        $sort = new Sort([
            'defaultOrder' => ['created_at' => SORT_DESC],
            'attributes' => [
                'type',
                'created_at',
                'name',
                'status'
            ],
        ]);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $query->asArray()->all(),
            'key' => 'id',
            'sort' => $sort
        ]);

        return $dataProvider;
    }
}
