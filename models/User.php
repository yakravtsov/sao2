<?php

namespace app\models;

use app\components\AuthorBehavior;
use Yii;
use yii\base\Event;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\VarDumper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property string       $created
 * @property string       $updated
 * @property integer      $author_id
 * @property integer      $user_id
 * @property integer      $role_id
 * @property integer      $parent_id
 * @property string       $email
 * @property string       $phio
 * @property integer      $company_id
 * @property string       $last_login
 * @property string       $password_hash
 * @property string       $password_reset_token
 * @property string       $auth_key
 * @property string       $status
 * @property string       $login_hash
 * @property string       $password write-only password
 * @property string       $subcompany
 * @property History[]    $histories
 * @property Company      $companies
 */
class User extends ActiveRecord implements IdentityInterface
{

	const ROLE_GUEST         = 0;
	const ROLE_WORKER        = 2;
	const ROLE_CLIENT        = 4;
	const ROLE_ADMINISTRATOR = 8;
	const ROLE_MANAGER 		 = 16;

	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE   = 1;
	protected $_password;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%user}}';
	}

	/**
	 * Finds an identity by the given ID.
	 *
	 * @param string|integer $id the ID to be looked for
	 *
	 * @return IdentityInterface the identity object that matches the given ID.
	 * Null should be returned if such an identity cannot be found
	 * or the identity is not in an active state (disabled, deleted, etc.)
	 */
	public static function findIdentity($id) {
		return static::findOne(['user_id' => $id, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by email
	 *
	 * @param $email
	 *
	 * @return null|static
	 */
	public static function findByEmail($email) {
		return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds an identity by the given token.
	 *
	 * @param mixed $token the token to be looked for
	 * @param mixed $type  the type of the token. The value of this parameter depends on the implementation.
	 *                     For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
	 *
	 * @return IdentityInterface the identity object that matches the given token.
	 * Null should be returned if such an identity cannot be found
	 * or the identity is not in an active state (disabled, deleted, etc.)
	 * @throws NotSupportedException
	 */
	public static function findIdentityByAccessToken($token, $type = NULL) {
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 *
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token) {
		$expire    = Yii::$app->params['user.passwordResetTokenExpire'];
		$parts     = explode('_', $token);
		$timestamp = (int) end($parts);
		if ($timestamp + $expire < time()) {
			// token expired
			return NULL;
		}

		return static::findOne([
			'password_reset_token' => $token,
			'status'               => self::STATUS_ACTIVE,
		]);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCompany() {
		return $this->hasOne(Company::className(), ['company_id' => 'company_id']);
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
	public function rules() {
		return [
			//['user_id', 'default', 'value' => NULL, 'on' => 'signup'],
			[['email', 'company_id', 'password'], 'required', 'on' => 'signup'],
			[['parent_id', 'company_id'], 'integer', 'on' => 'signup'],
			[['email', 'phio', 'subcompany'], 'string', 'max' => 255, 'on' => 'signup'],
			[['email'], 'email', 'on' => 'signup'],
			['email', 'filter', 'filter' => 'trim'],
			['email', 'unique', 'message' => 'Этот адрес уже занят.', 'on' => 'signup'],
			['email', 'exist', 'message' => 'Пользователь с таким email не найден.', 'on' => 'requestPasswordResetToken'],
			['status', 'default', 'value' => self::STATUS_ACTIVE],
			['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
			['role_id', 'default', 'value' => self::ROLE_WORKER, 'on' => 'signup'],
			['role_id', 'in', 'range' => [self::ROLE_WORKER, self:: ROLE_CLIENT, self::ROLE_ADMINISTRATOR, self::ROLE_MANAGER], 'on' => 'signup'],
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function scenarios() {
		return [
			'signup'                    => ['user_id', 'email', 'password', '!status', '!role', 'role_id', 'phio', 'company_id', 'subcompany', 'parent_id'],
			'update'                    => ['user_id', 'email', 'password', '!status', '!role', 'role_id', 'phio', 'company_id', 'subcompany', 'parent_id'],
			'default'                   => [],
			//			'resetPassword' => ['password'],
			'requestPasswordResetToken' => ['email'],
		];
	}

	public function getRoleLabel() {
		$keys = $this->getRoleValues();

		return array_key_exists($this->role_id, $keys) ? $keys[$this->role_id] : 'Неизвестная роль';
	}

	/**
	 * @return array
	 */
	public function getRoleValues() {
		$commonRoles = [
			self::ROLE_WORKER        => 'Сотрудник',
			self::ROLE_CLIENT        => 'Клиент',
		];
		$devRoles = [
			self::ROLE_ADMINISTRATOR => "Администратор",
			self::ROLE_MANAGER => "Менеджер"
		];
		switch(self::findIdentity(Yii::$app->user->id)->role_id){
			case self::ROLE_ADMINISTRATOR:
				return $commonRoles + $devRoles;
			case self:: ROLE_MANAGER:
				return $commonRoles;
			default: return [];
		}
	}

	public function getStatusLabel() {
		$keys = $this->getStatusValues();

		return array_key_exists($this->status, $keys) ? $keys[$this->status] : 'Неизвестный статус';
	}

	/**
	 * @return array
	 */
	public function getStatusValues() {
		$keys = [
			self::STATUS_ACTIVE   => 'Активен',
			self::STATUS_INACTIVE => 'Заблокирован',
		];

		return $keys;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'created'    => 'Создан',
			'updated'    => 'Редактирован',
			'author_id'  => 'Автор',
			'user_id'    => 'ID',
			'role_id'    => 'Роль',
			'parent_id'  => 'Parent ID',
			'email'      => 'Email',
			'phio'       => 'Ф. И. О.',
			'company_id' => 'Организация',
			'password'   => 'Пароль',
			'last_login' => 'Последний вход',
			'status'     => 'Статус',
			'login_hash' => 'Хэш входа',
			'subcompany' => 'Подразделение',
		];
	}

	/**
	 * Returns an ID that can uniquely identify a user identity.
	 *
	 * @return string|integer an ID that uniquely identifies a user identity.
	 */
	public function getId() {
		return $this->getPrimaryKey();
	}

//	public function save($runValidation = true, $attributeNames = null){
//		switch($this->getScenario()){
//			case 'update':
//				if($this->password){
//
//				}
//				parent::save($runValidation,$attributeNames)
//		}
//
//		if($this->getScenario() == 'update'){
//
//		}
//	}

	/**
	 * Validates the given auth key.
	 * This is required if [[User::enableAutoLogin]] is enabled.
	 *
	 * @param string $authKey the given auth key
	 *
	 * @return boolean whether the given auth key is valid.
	 * @see getAuthKey()
	 */
	public function validateAuthKey($authKey) {
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Returns a key that can be used to check the validity of a given identity ID.
	 * The key should be unique for each individual user, and should be persistent
	 * so that it can be used to check the validity of the user identity.
	 * The space of such keys should be big enough to defeat potential identity attacks.
	 * This is required if [[User::enableAutoLogin]] is enabled.
	 *
	 * @return string a key that is used to check the validity of a given identity ID.
	 * @see validateAuthKey()
	 */
	public function getAuthKey() {
		return '';
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 *
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password) {
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}

	public function getPassword() {
		return $this->scenario == 'signup' ? $this->_password : 'a';
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password) {
		$this->_password     = $password;
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken() {
		$this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken() {
		$this->password_reset_token = NULL;
	}

	public function generateLoginHash($email) {
		$this->login_hash = hash('ripemd160', date('mdYhis', time()) . $email);
		//return hash('ripemd160',date('mdYhis', time()) . $email);
	}

	public function getAuthorName() {
		return $this->getAuthor();
	}

	/**
	 * @return ActiveQuery
	 */
	public function getAuthor() {
		return $this->hasMany(self::className(), ['user_id' => 'author_id'])->AsArray()->One();
	}

	public function getCompanies() {
		$array = Company::find()->asArray()->all();
		$data  = [];
		foreach ($array as $a) {
			$data[$a['company_id']] = $a['name'];
		}

		return $data;
	}

	public function getCompanyName() {
		$va    = new Company();
		$array = $va::find()->select(['company_id', 'name'])->asArray()->All();
		$keys  = [];
		foreach ($array as $a) {
			$keys[$a['company_id']] = $a['name'];
		}

		return array_key_exists($this->company_id, $keys) ? $keys[$this->company_id] : 'Неизвестная организация';
	}

	public function generatePassword() {
		return substr(hash('haval160,4', $this->email . $this->phio . time()), -8);
	}
}
