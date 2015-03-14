<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['created', 'updated', 'email', 'phio', 'subcompany', 'last_login', 'password_reset_token', 'password_hash'], 'safe'],
			[['author_id', 'user_id', 'role_id', 'parent_id', 'company_id', 'status'], 'integer'],
		    //['subcompany', 'string']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
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
	public function search($params) {
		$query = User::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		$query->andFilterWhere([
			'created'    => $this->created,
			'updated'    => $this->updated,
			'author_id'  => $this->author_id,
			'user_id'    => $this->user_id,
			'role_id'    => $this->role_id,
			'parent_id'  => $this->parent_id,
			'company_id' => $this->company_id,
			//'subcompany' => $this->subcompany,
			'last_login' => $this->last_login,
			'status'     => $this->status,
		]);

		$query->andFilterWhere(['like', 'email', $this->email])
		      ->andFilterWhere(['like', 'phio', $this->phio])
		      ->andFilterWhere(['like', 'subcompany', $this->subcompany])
		      ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
		      ->andFilterWhere(['like', 'password_hash', $this->password_hash]);

		return $dataProvider;
	}
}
