<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "organization".
 *
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $level
 *
 * @property User[] $users
 */
class Organization extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'updated'], 'safe'],
            [['author_id', 'id', 'name'], 'required'],
            [['author_id', 'id', 'parent_id', 'level'], 'integer'],
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
            'id' => 'ID',
            'name' => 'Название',
            'parent_id' => 'Родительское подразделение',
            'level' => 'Уровень',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['organization_id' => 'id']);
    }
}
