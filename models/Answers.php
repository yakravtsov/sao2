<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "answers".
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
class Answers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answers';
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
}
