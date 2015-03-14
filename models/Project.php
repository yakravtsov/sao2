<?php

namespace app\models;

use app\components\AuthorBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "project".
 *
 * @property integer $project_id
 * @property string  $created
 * @property string  $updated
 * @property integer $author_id
 * @property string  $date_start
 * @property string  $date_end
 * @property integer $report_type
 * @property string  $description
 * @property integer $notify
 */
class Project extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'project';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			//[['date_start', 'date_end'], 'safe'],
			[['report_type', 'notify'], 'integer'],
			[['description'], 'string'],
			['date_start', 'compare', 'compareAttribute'=>'date_end','operator'=>'>', 'skipOnEmpty'=>true],
			/*[['date_start', 'date_end'], 'validateDate', /*'when' => function ($model) {
					return $model->date_start AND $model->date_end;
				}],*/
			//			[['date_start'], 'compare', 'compareAttribute'=>'date_end', 'operator'=>'<=', 'skipOnEmpty'=>true],
			//			[['date_end'], 'compare', 'compareAttribute'=>'date_start', 'operator'=>'>=']
		];
	}

	public function validateDate($attribute, $param) {

		if ((strtotime($this->date_start) > strtotime($this->date_end)) && !empty($this->date_end)) {
			$this->addError('date_start','sadfdasdfd');
			$this->addError('date_end','sadfdasdfd');
			//$this->addErrors(['date_start' => 'eroarea1', 'date_end' => 'eroarea2']);
		}
		//here your validation
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			[
				'class'              => TimestampBehavior::className(),
				'createdAtAttribute' => 'created',
				'updatedAtAttribute' => 'updated',
				'value'              => new Expression('NOW()'),
			],
			[
				'class'     => AuthorBehavior::className(),
				'attribute' => 'author_id',
			]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'project_id'  => '#',
			'created'     => 'Создан',
			'updated'     => 'Updated',
			'author_id'   => 'Author ID',
			'date_start'  => 'Date Start',
			'date_end'    => 'Date End',
			'report_type' => 'Report Type',
			'description' => 'Description',
			'notify'      => 'Notify',
		];
	}

	public function getCompanies() {
		return $this->hasMany(Company::className(), ['company_id' => 'company_id'])
					->viaTable('project_company', ['project_id' => 'project_id']);
	}
}
