<?php

namespace app\models;

use app\components\AuthorBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "answer".
 *
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property integer $answer_id
 * @property integer $question_id
 * @property string $answer
 *
 * @property Question $question
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer';
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
    public function rules()
    {
        return [
            [['created', 'updated'], 'safe'],
            [['author_id', 'lft', 'rgt', 'depth', 'question_id', 'answer'], 'required'],
            [['author_id', 'root', 'lft', 'rgt', 'depth', 'question_id'], 'integer'],
            [['answer'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created' => 'Created',
            'updated' => 'Updated',
            'author_id' => 'Author ID',
            'root' => 'Root',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'answer_id' => 'Answer ID',
            'question_id' => 'Вопрос',
            'answer' => 'Ответ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['question_id' => 'question_id']);
    }

	public function getEffects(){
		return $this->hasMany(AnswerScale::className(), ['answer_id'=>'answer_id'])/*->indexBy('scale_id')*/;
	}

}
