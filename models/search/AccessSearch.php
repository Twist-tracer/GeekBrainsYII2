<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Access;

/**
 * AccessSearch represents the model behind the search form about `app\models\Access`.
 */
class AccessSearch extends Access
{
    public $groupBy; //For grouping
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_owner', 'user_guest'], 'integer'],
            [['date'], 'safe'],
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
        if (isset($params['query'])) {
            $query = $params['query'];
        } else {
            $query = Access::find();
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate())
        {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($this->groupBy)
        {
            $query->groupBy($this->groupBy);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_owner' => $this->user_owner,
            'user_guest' => $this->user_guest,
            'date' => $this->date,
        ]);

        return $dataProvider;
    }
}
