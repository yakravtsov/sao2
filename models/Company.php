<?php

namespace app\models;

use app\components\AuthorBehavior;
use yii\behaviors\TimestampBehavior;
use yii\base\NotSupportedException;
use yii\db\Expression;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "Company".
 *
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property integer $company_id
 * @property string $name
 * @property integer $parent_id
 * @property integer $level
 *
 * @property User[] $users
 */
class Company extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
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
            //[['created', 'updated'], 'safe'],
            [['parent_id', 'name'], 'required'],
            [['parent_id', 'level'], 'integer'],
            [['name'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created' => 'Дата создания',
            'updated' => 'Дата изменения',
            'author_id' => 'Автор',
            'company_id' => 'ID',
            'name' => 'Название',
            'parent_id' => 'Родительское подразделение',
            'level' => 'Уровень',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthor() {
        return $this->hasMany(User::className(), ['user_id' => 'author_id'])->AsArray()->One();
        //return $this->hasMany(User::className(), ['author_id' => 'author_id'])->AsArray()->One();
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['company_id' => 'user_id']);
    }
}
