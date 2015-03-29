<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "competence".
 *
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property integer $competence_id
 * @property string $name
 * @property string $description
 * @property string $code
 *
 * @property ProjectCompetence[] $projectCompetences
 * @property Project[] $projects
 */
class Competence extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'competence';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'updated'], 'safe'],
            [['author_id', 'name', 'description', 'code'], 'required'],
            [['author_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 30]
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
            'competence_id' => 'Competence ID',
            'name' => 'Name',
            'description' => 'Description',
            'code' => 'Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectCompetences()
    {
        return $this->hasMany(ProjectCompetence::className(), ['competence_id' => 'competence_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['project_id' => 'project_id'])->viaTable('project_competence', ['competence_id' => 'competence_id']);
    }
}
