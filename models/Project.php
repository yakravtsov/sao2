<?php

namespace app\models;

use Yii;

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
            [['created', 'updated', 'date_start', 'date_end'], 'safe'],
            [['author_id'], 'required'],
            [['author_id', 'report_type', 'notify'], 'integer'],
            [['description'], 'string']
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
