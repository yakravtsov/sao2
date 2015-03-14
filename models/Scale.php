<?php

namespace app\models;

use app\components\AuthorBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "scale".
 *
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property integer $scale_id
 * @property string $name
 * @property integer $test_id
 * @property integer $default
 *
 * @property Test $test
 */
class Scale extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scale';
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
            [['test_id', 'default'], 'integer'],
            [['test_id', 'default', 'name'], 'required'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created' => 'Создана',
            'updated' => 'Редактирована',
            'author_id' => 'Автор',
            'scale_id' => 'ID',
            'name' => 'Название',
            'test_id' => 'ID теста',
            'default' => 'Значение по умолчанию',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['test_id' => 'test_id']);
    }
}
