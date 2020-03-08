<?php

namespace thread\modules\user\models;

use thread\modules\company\models\Company;
use thread\modules\sanatorium\models\Sanatoriums;
use Yii;
use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * Class User
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class User extends \thread\models\ActiveRecord implements IdentityInterface
{
    const GROUP_ADMIN = 'admin';
    const GROUP_ADMIN_COMPANY = 'admin_company';
    const GROUP_ADMIN_SANATORIUM = 'admin_sanatorium';
    const GROUP_WORKER_SANATORIUM = 'worker_sanatorium';
    const GROUP_USER = 'user';

    const ROLE_USER = 10;

    /**
     * @var string
     */
    public static $commonQuery = query\UserQuery::class;

    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\user\User::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'unique'],
            [['username'], 'required'],
            [['group_id', 'company_id', 'sanatorium_id', 'role', 'create_time', 'update_time'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['auth_key'], 'string', 'max' => 32],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => [self::ROLE_USER]],
            [['company_id', 'sanatorium_id'], 'default', 'value' => 0,]
        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => ['username', 'company_id', 'sanatorium_id', 'email', 'published', 'deleted', 'group_id'],
            'usercreate' => ['username', 'email', 'published', 'group_id'],
            'passwordchange' => ['password_hash'],
            'profile' => ['username'],
        ];
    }

    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'group_id' => Yii::t('app', 'group'),
            'username' => Yii::t('user', 'username'),
            'auth_key' => Yii::t('app', 'auth_key'),
            'password_hash' => Yii::t('app', 'password_hash'),
            'password_reset_token' => Yii::t('app', 'password_reset_token'),
            'email' => Yii::t('app', 'email'),
            'role' => Yii::t('app', 'role'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'sanatorium_id' => Yii::t('user', 'sanatorium_id'),
            'company_id' => Yii::t('user', 'company_id')
        ];
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    /**
     * Get Company by user id
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    /**
     * Get Sanatorium by user id
     * @return \yii\db\ActiveQuery
     */
    public function getSanatorium()
    {
        return $this->hasOne(Sanatoriums::class, ['id' => 'sanatorium_id']);
    }

    public static function dropDownList($company_id = null, $sanatorium_id = null)
    {
        $users = self::find_base();

        if ($company_id) {
            $users = $users->andWhere(['company_id' => $company_id]);
        }

        if ($sanatorium_id) {
            $users = $users->andWhere(['sanatorium_id' => $sanatorium_id]);
        }

        return ArrayHelper::map($users->all(), 'id', 'username');
    }

    /**
     * Get list by group_id
     * @param null $group_id
     * @return array
     */
    public static function dropDownListByGroup($group_id = null)
    {
        $users = self::find_base();

        if ($group_id) {
            $users = $users->group_id($group_id);
        }

        return ArrayHelper::map($users->all(), 'id', 'username');
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }

    /**
     *
     * @param type $id
     * @return ActiveRecord|null
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()->username($username)->enabled()->one();
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return self::find()->email($email)->enabled()->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::find()->password_reset_token($token)->enabled()->one();
    }

    /**
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     *
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     *
     * @param string $authKey
     * @return boollean
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
        return $this;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
        return $this;
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
        return $this;
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
        return $this;
    }

    /**
     *
     * @param boollean $insert
     * @param type $changedAttributes
     * @return boollean
     */
    public function afterSave($insert, $changedAttributes)
    {

        $this->setRole();

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Втановлення ролі користувачу при зміні групи
     */
    protected function setRole()
    {

        Yii::$app->authManager->revokeAll($this->id);

        $role = Yii::$app->authManager->getRole($this->group->role);
        if ($role !== null) {
            Yii::$app->authManager->assign($role, $this->id);
        }
    }

    public static function getUserGroup()
    {
        return isset(Yii::$app->user->identity->group->role) ? Yii::$app->user->identity->group->role : false;
    }

    public static function getListUserGroup()  {
        return [
            self::GROUP_ADMIN,
            self::GROUP_ADMIN_COMPANY,
            self::GROUP_ADMIN_SANATORIUM,
            self::GROUP_WORKER_SANATORIUM,
            self::GROUP_USER,
        ];
    }

}
