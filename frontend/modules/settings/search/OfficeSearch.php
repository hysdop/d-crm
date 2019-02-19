<?php

namespace frontend\modules\settings\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\repositories\OfficeRepository;
use yii\data\ArrayDataProvider;
use yii\db\Query;

/**
 * OfficeSearch represents the model behind the search form about `common\repositories\OfficeRepository`.
 */
class OfficeSearch extends OfficeRepository
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'status', 'company_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'phone', 'phone_second'], 'safe'],
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
            ->select('o.*')
            ->from('{{%office}} o')
            ->where(['company_id' => Yii::$app->user->identity->company_id]);

        $this->load($params);

        $query->andFilterWhere([
            'type' => $this->type,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'phone_second', $this->phone_second]);

        return new ArrayDataProvider([
            'allModels' => $query->all(),
            'key' => 'id'
        ]);
    }
}
