<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\repositories\CompanyRepository;

/**
 * CompanySearch represents the model behind the search form about `common\repositories\CompanyRepository`.
 */
class CompanySearch extends CompanyRepository
{
    public $filterPhone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'address_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'phone', 'phone_second', 'filterPhone'], 'safe'],
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
        $query = CompanyRepository::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'address_id' => $this->address_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        // фильтр по телефону
        $query->andWhere(
            'phone LIKE "%' . $this->filterPhone . '%" ' .
            'OR phone_second LIKE "%' . $this->filterPhone . '%"'
        );

        return $dataProvider;
    }
}
