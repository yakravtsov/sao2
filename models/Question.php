<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "question".
 *
 * @property string    $created
 * @property string    $updated
 * @property integer   $author_id
 * @property integer   $question_id
 * @property string    $name
 * @property integer   $type
 * @property integer   $test_id
 * @property integer   $root
 * @property integer   $lft
 * @property integer   $rgt
 * @property integer   $depth
 *
 * @property Test      $test
 * @property Answer    $answers
 */
class Question extends ActiveRecord
{
	const TYPE_CHECKBOX    = 1;
	const TYPE_RADIO       = 2;
	const TYPE_INPUT       = 4;
	const TYPE_RANGE       = 8;
	const TYPE_PRIORITY    = 16;
	const TYPE_RATING      = 32;
	const TYPE_CORRELATION = 64;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'question';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['created', 'updated'], 'safe'],
			[['author_id', 'lft', 'rgt', 'depth'], 'required'],
			[['author_id', 'type', 'test_id', 'root', 'lft', 'rgt', 'depth'], 'integer'],
			[['name'], 'string', 'max' => 255]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'created'     => 'Created',
			'updated'     => 'Updated',
			'author_id'   => 'Author ID',
			'question_id' => 'Question ID',
			'name'        => 'Name',
			'type'        => 'Type',
			'test_id'     => 'Test ID',
			'root'        => 'Root',
			'lft'         => 'Lft',
			'rgt'         => 'Rgt',
			'depth'       => 'Depth',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTest() {
		return $this->hasOne(Test::className(), ['test_id' => 'test_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAnswers() {
		return $this->hasMany(Answer::className(), ['test_id' => 'test_id']);
	}



	/**
	 * @return array
	 */
	public function getTypes() {
		return [
			self::TYPE_RADIO       => 'Один вариант ответа',
			self::TYPE_CHECKBOX    => 'Несколько вариантов ответа',
			self::TYPE_INPUT       => 'Свободный ответ',
			self::TYPE_RANGE       => 'Интервал',
			self::TYPE_PRIORITY    => 'Ранжирование',
			self::TYPE_RATING      => 'Рейтинг (присваивание баллов)',
			self::TYPE_CORRELATION => 'Сопоставление',
		];
	}

}

