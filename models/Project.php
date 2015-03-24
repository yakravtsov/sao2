<?php

namespace app\models;

use app\components\AuthorBehavior;
use app\components\DatestartendValidator;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
 * @property integer $settings
 */
class Project extends ActiveRecord
{

	const TYPE_COMPETENCE = 1;
	const TYPE_TEST       = 2;

	public function getType() {
		return $this->isCompetenceType() ? self::TYPE_COMPETENCE : self::TYPE_TEST;
	}

	public function isCompetenceType() {
		return $this->_checkSetting(self::TYPE_COMPETENCE);
	}

	public function setType($type) {
		$this->_checkSetting($type, TRUE);

		return $this;
	}

	public function getTypeLabel() {
		$keys = $this->getTypeValues();

		return array_key_exists($this->type, $keys) ? $keys[$this->type] : 'Неизвестный тип';
	}

	/**
	 * @return array
	 */
	public function getTypeValues() {
		$keys = [
			self::TYPE_TEST       => 'Тест или группа тестов',
			self::TYPE_COMPETENCE => 'Модель компетенций',
		];

		return $keys;
	}


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
			[['date_start', 'date_end', 'type'], 'safe'],
			[['date_start', 'date_end', 'name'], 'required'],
			[['report_type', 'settings'], 'integer'],
			//['companies', 'required'],
			/*[['tests'], 'required', 'whenClient' => "function (attribute, value) {
                return $('#project-type input').val() == " . self::TYPE_TEST . "
            }"],*/
			/*[['competencies'], 'required', 'whenClient' => "function (attribute, value) {
                return $('#project-type input').val() == " . self::TYPE_COMPETENCE . "
            }"],*/
			[['description'], 'string'],
			[['date_start', 'date_end'], DatestartendValidator::className(), 'whenClient' => "function (attribute, value) {
        return $('#project-date_start').val() !== '' && $('#project-date_end').val() !== '';
    }"]
		];
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
			'project_id'   => '#',
			'created'      => 'Создан',
			'updated'      => 'Редактирован',
			'author_id'    => 'Автор',
			'date_start'   => 'Дата начала',
			'date_end'     => 'Дата окончания',
			'report_type'  => 'Вид отчёта',
			'description'  => 'Описание',
			'settings'     => 'settings',
			'companies'    => 'Компания',
			'tests'        => 'Тесты',
			'competencies' => 'Компетенции',
			'type'         => 'Тип тестирования',
			'name'         => 'Название',
		];
	}


	public function getCompanies() {
		return $this->hasOne(Company::className(), ['company_id' => 'company_id'])
		            ->viaTable('project_company', ['project_id' => 'project_id']);
	}

	public function setCompanies() {
		return TRUE;
	}

	public function getCompany($company_id) {
		//return Company::find(['company_id'=>$this->company_id]);
		return Company::findOne(['company_id'=>$company_id])->AsArray();
	}

	public function getTests() {
		return $this->hasMany(Test::className(), ['test_id' => 'test_id'])
		            ->viaTable('project_test', ['project_id' => 'project_id']);
	}

	public function setTests() {
		return TRUE;
	}

	public function setCompetencies() {
		return TRUE;
	}

	/*protected function setTests()
	{
		ProjectTest::model()->updateFrequency($this->_oldTags, $this->tags);
	}*/

	public function getCompetencies() {
		return $this->hasMany(Competence::className(), ['competence_id' => 'competence_id'])
		            ->viaTable('project_competence', ['project_id' => 'project_id']);
	}


	public function setCompetenceType() {
		$this->settings &= self::TYPE_COMPETENCE;

		return $this;
	}

	private function _checkSetting($setting, $update = FALSE) {
		if ($update) {
			return $this->settings &= $setting;
		}

		return $this->settings & $setting;
	}

	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert) {
		$this->date_start = Yii::$app->formatter->asDatetime($this->date_start, 'Y-M-d 00:00:00');
		$this->date_end   = Yii::$app->formatter->asDatetime($this->date_end, 'Y-M-d 00:00:00');

		return parent::beforeSave($insert);
	}

	public function afterFind() {
		parent::afterFind();
		$this->date_start = Yii::$app->formatter->asDatetime($this->date_start, 'd.MM.Y');
		$this->date_end   = Yii::$app->formatter->asDatetime($this->date_end, 'd.MM.Y');

	}
}
