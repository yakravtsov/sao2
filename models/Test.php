<?php

namespace app\models;

use app\components\AuthorBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "test".
 *
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property integer $test_id
 * @property string $name
 * @property string $description
 * @property integer $order
 * @property integer $settings
 * @property integer $deadline
 *
 * @property Question[] $questions
 * @property Scale[] $scales
 */
class Test extends \yii\db\ActiveRecord
{
    const QUESTIONS_ORDER = 0;
    const QUESTIONS_RANDOM = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test';
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
            [['settings', 'deadline'], 'integer'],
            [['description'], 'string'],
            ['order', 'in', 'range' => [self::QUESTIONS_ORDER, self::QUESTIONS_RANDOM]],
            [['name'], 'string', 'max' => 255],
//            [['deadline'], 'integer', ']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created' => 'Создан',
            'updated' => 'Редактирован',
            'author_id' => 'Автор',
            'test_id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'order' => 'Порядок вопросов',
            'settings' => 'Настройки',
            'deadline' => 'Время в минутах',
        ];
    }

    public function getOrderList()
    {
        return [
            self::QUESTIONS_ORDER => 'Определенный',
            self::QUESTIONS_RANDOM => 'Случайный',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['test_id' => 'test_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScales()
    {
        return $this->hasMany(Scale::className(), ['test_id' => 'test_id']);
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['user_id' => 'author_id']);
    }

    public function getAuthorName()
    {
        return $this->getAuthor()['phio'];
    }
}
