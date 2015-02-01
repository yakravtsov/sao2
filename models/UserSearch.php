<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
	public $author;

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['user_id'], 'integer'],
            [['phio', 'created', 'author'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return User::scenarios();
    }

    public function search($params)
    {
        $query = User::find();
		$query->leftJoin(['author']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // load the seach form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['user_id' => $this->id]);
        $query->andFilterWhere(['like', 'phio', $this->phio])
		->andFilterWhere(['author.phio'=>$this->author])
            ->andFilterWhere(['like', 'created', $this->creation_date]);

        return $dataProvider;
    }
}