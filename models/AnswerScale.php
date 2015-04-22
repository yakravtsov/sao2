<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "answer_scale".
 *
 * @property integer $answer_id
 * @property integer $scale_id
 * @property string $operation
 * @property integer $value
 *
 * @property Answer $answer
 * @property Scale $scale
 */
class AnswerScale extends \yii\db\ActiveRecord
{
	const ADD = 1; // Сумма
	const DEDUCT = 2; // Разность
	const MULTIPLY = 3; // Умножение
	const DIVIDE = 4; // Деление
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer_scale';
    }

	public static function getOperations() {
		return [
			self::ADD => 'прибавить',
			self::DEDUCT => 'вычесть',
			self::MULTIPLY => 'умножить',
			self::DIVIDE => 'разделить',
		];
	}

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer_id', 'scale_id'], 'required'],
            [['answer_id', 'scale_id', 'value'], 'integer'],
            [['operation'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'answer_id' => 'Answer ID',
            'scale_id' => 'Scale ID',
            'operation' => 'Operation',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::className(), ['answer_id' => 'answer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScale()
    {
        return $this->hasOne(Scale::className(), ['scale_id' => 'scale_id']);
    }
}
