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
 * This is the model class for table "feedback".
 *
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property integer $feedback_id
 * @property string $email
 * @property string $name
 * @property string $phone
 * @property integer $status
 * @property string $text
 */
class Feedback extends ActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_ANSWERED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * @inheritdoc
     */
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
            //['author_id', 'value' => 0],
            [['text', 'email', 'name'], 'required'],
            [['author_id', 'status'], 'integer'],
            [['text'], 'string'],
            [['email', 'name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 30]
        ];
    }

    public function getStatusLabel()
    {
        $keys = $this->getStatusValues();

        return array_key_exists($this->status, $keys) ? $keys[$this->status] : 'Неизвестный статус';
    }

    /**
     * @return array
     */
    public function getStatusValues()
    {
        $keys = [
            self::STATUS_NEW => 'Новое',
            self::STATUS_ANSWERED => 'Обработано',
        ];

        return $keys;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created' => 'Дата создания',
            'updated' => 'Дата редактирования',
            'author_id' => 'Автор',
            'feedback_id' => 'ID',
            'email' => 'Email',
            'name' => 'Ф. И. О.',
            'phone' => 'Номер телефона',
            'status' => 'Статус',
            'text' => 'Сообщение'
        ];
    }
}
