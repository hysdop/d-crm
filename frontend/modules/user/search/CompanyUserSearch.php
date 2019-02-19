<?php

namespace frontend\modules\user\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\repositories\UserRepository;
use yii\data\ArrayDataProvider;
use yii\data\Sort;
use yii\db\Expression;
use yii\db\Query;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class CompanyUserSearch extends UserRepository
{
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'logged_at', 'office_id'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'email', 'name'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = (new Query())
            ->select(new Expression('u.*, 
                concat(p.`firstname`, \' \', p.lastname, \' \', p.middlename) name, 
                o.name office'))
            ->from('{{%user}} u')
            ->innerJoin('{{%user_profile}} p', 'p.user_id = u.id')
            ->leftJoin('{{%office}} o', 'o.id = u.office_id')
            ->where(['u.company_id' => Yii::$app->user->identity->company_id]);

        if (!($this->load($params) && $this->validate())) {
            //return $dataProvider;
        }

        if ($this->logged_at)
            $query->andFilterWhere(['=', new Expression('from_unixtime(logged_at, \'%Y-%m-%d\')'), $this->logged_at]);

        if ($this->created_at)
            $query->andFilterWhere(['=', new Expression('from_unixtime(created_at, \'%Y-%m-%d\')'), $this->created_at]);

        $query->andFilterWhere([
            'id' => $this->id,
            'u.status' => $this->status,
            'office_id' => $this->office_id,
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

        $sort = new Sort([
            'defaultOrder' => ['created_at' => SORT_DESC],
            'attributes' => [
                'created_at',
                'logged_at',
                'name' => [
                    'asc' => ['p.firstname' => SORT_ASC, 'p.lastname' => SORT_ASC, 'p.middlename' => SORT_ASC],
                    'desc' => ['p.firstname' => SORT_DESC, 'p.lastname' => SORT_DESC, 'p.middlename' => SORT_DESC],
                    'default' => SORT_DESC,
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
