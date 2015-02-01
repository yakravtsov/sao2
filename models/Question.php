<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property integer $question_id
 * @property string $name
 * @property integer $type
 * @property integer $test_id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 *
 * @property QuestionScale[] $questionScales
 * @property Test $test
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
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
    public function attributeLabels()
    {
        return [
            'created' => 'Created',
            'updated' => 'Updated',
            'author_id' => 'Author ID',
            'question_id' => 'Question ID',
            'name' => 'Name',
            'type' => 'Type',
            'test_id' => 'Test ID',
            'root' => 'Root',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionScales()
    {
        return $this->hasMany(QuestionScale::className(), ['question_id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['test_id' => 'test_id']);
    }
}
