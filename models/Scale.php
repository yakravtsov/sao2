<?php

namespace app\models;

use Yii;

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
    public function rules()
    {
        return [
            [['created', 'updated'], 'safe'],
            [['author_id'], 'required'],
            [['author_id', 'test_id', 'default'], 'integer'],
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
