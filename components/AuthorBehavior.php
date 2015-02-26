<?php
namespace app\components;

//use app\models\User;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;

class AuthorBehavior extends Behavior
{
	public $attribute;

	public function events()
	{
		return [
			ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
//			ActiveRecord::EVENT_INIT => 'getAuthor',
		];
	}

	/**
	 * @param $event Event
	 */
	public function beforeInsert($event)
	{
		$event->sender->author_id = is_null(\Yii::$app->user->getId()) ? 0 : \Yii::$app->user->getId();
	}

	/*public function getAuthor()
	{
		return $this->owner->hasMany(User::className(), ['user_id' => 'author_id'])->AsArray()->One();
	}*/
}