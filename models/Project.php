<?php

namespace app\models;

use app\components\AuthorBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "project".
 *
 * @property integer $project_id
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property string $date_start
 * @property string $date_end
 * @property integer $report_type
 * @property string $description
 * @property integer $notify
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_start', 'date_end'], 'safe'],
            [['report_type', 'notify'], 'integer'],
            [['description'], 'string']
        ];
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
    public function attributeLabels()
    {
        return [
            'project_id' => '#',
            'created' => 'Создан',
            'updated' => 'Updated',
            'author_id' => 'Author ID',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'report_type' => 'Report Type',
            'description' => 'Description',
            'notify' => 'Notify',
        ];
    }
}
