<?php

namespace app\models;

use app\components\AuthorBehavior;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "feedback_answer".
 *
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property integer $feedback_answer_id
 * @property string $text
 * @property integer $feedback_id
 * @property string $email
 */
class FeedbackAnswer extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback_answer';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => AuthorBehavior::className(),
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
            //[['feedback_answer_id'], 'required'],
            [['author_id', 'feedback_id'], 'integer'],
            [['text'], 'required'],
            [['text'], 'string'],
            [['email'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created' => 'Дата создания',
            'updated' => 'Дата обновления',
            'author_id' => 'Автор',
            'feedback_answer_id' => 'ID',
            'text' => 'Текст ответа',
            'email' => 'Email',
            'feedback_id' => 'ID вопроса',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedback()
    {
        return $this->hasOne(Feedback::className(), ['feedback_id' => 'feedback_id']);
    }
}
