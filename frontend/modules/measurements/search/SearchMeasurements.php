<?php

namespace frontend\modules\measurements\search;

use common\repositories\UserProfileRepository;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\repositories\MeasurementsRepository;
use yii\data\ArrayDataProvider;
use yii\data\Sort;
use yii\db\Expression;
use yii\db\Query;

/**
 * search represents the model behind the search form about `common\repositories\MeasurementsRepository`.
 */
class SearchMeasurements extends MeasurementsRepository
{
    public $name;

    public $dateFrom;
    public $dateTo;
    public $dateRange;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'constructions', 'employee_id', 'client_id', 'created_at', 'updated_at'], 'integer'],
            [['firstname', 'lastname', 'middlename', 'date', 'name', 'dateFrom', 'dateTo', 'dateRange'], 'safe'],
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

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'name' => 'Имя'
        ]);
    }

    public function init()
    {
        parent::init();

        if (!$this->dateFrom) $this->dateFrom = date('Y-m-d', strtotime('-1 year'));
        if (!$this->dateTo) $this->dateTo = date('Y-m-d', strtotime('+1 day'));
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
            ->select(new Expression('
                concat(e.`firstname`, \' \', e.lastname) employeeName, 
                concat(m.`firstname`, \' \', m.lastname, \' \', m.middlename) name,
                m.*'))
            ->from(MeasurementsRepository::tableName() . ' m')
            ->leftJoin(UserProfileRepository::tableName() . ' e', 'e.user_id = m.employee_id')
            ->where(['m.user_id' => Yii::$app->user->id])
            ->andWhere(['m.company_id' => Yii::$app->user->identity->company_id]);

        $this->load($params);

        if (!$this->dateFrom) $this->dateFrom = '2017-01-01';
        if (!$this->dateTo) $this->dateTo = date('Y-m-d', strtotime('+1 day'));

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'date' => $this->date,
            'constructions' => $this->constructions,
            'employee_id' => $this->employee_id,
            'client_id' => $this->client_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        // фильтр по имени
        if ($this->name) {
            $names = explode(' ', preg_replace('/\s+/', ' ', $this->name));
            if (count($names) <= 3) {
                foreach ($names as $item) {
                    $query->andFilterHaving(['or', ['like', 'name',  $item]]);
                }
            }
        }

        $query->andFilterWhere(['>=', 'created_at', strtotime($this->dateFrom)])
            ->andFilterWhere(['<=', 'created_at', strtotime($this->dateTo)]);

        $sort = new Sort([
            'defaultOrder' => ['created_at' => SORT_DESC],
            'attributes' => [
                'created_at',
                'name' => [
                    'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                    'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'Name',
                ],
            ],
        ]);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $query->all(),
            'sort' => $sort,
            'key' => 'id'
        ]);

        return $dataProvider;
    }
}
