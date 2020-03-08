<?php

namespace thread\modules\user\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class CommonForm
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class CommonForm extends Model {

    const FLASH_KEY = 'CommonForm';

    //attribute
    public $group_id;
    public $username;
    public $email;
    public $password;
    public $password_old;
    public $company_id;
    public $sanatorium_id;
    public $captcha;

    public $rememberMe = true;
    public $password_confirmation;
    //private setting
    private $_username_attribute = 'email';
    private $_password_min_length = 1;
    protected $_auto_login_after_register = true;

    /**
     * = 3600*24*30
     * @var integer
     */
    private $_time_remember_user_sigin = 2592000;
    //
    private $_user = null;

    public function init() {

        $this->_username_attribute = Yii::$app->getModule('user')->username_attribute;
        $this->_password_min_length = Yii::$app->getModule('user')->password_min_length;
        $this->_auto_login_after_register = Yii::$app->getModule('user')->auto_login_after_register;
        $this->_time_remember_user_sigin = Yii::$app->getModule('user')->time_remember_user_sigin;

        parent::init();
    }

    /**
     * 
     * @return string
     */
    public static function getDb() {
        return \thread\modules\user\User::getDb();
    }

    /**
     * 
     * @return array
     */
    public function rules() {
        $r = [
            [['email'], 'required', 'on' => ['usercreate']],
            [['group_id'], 'required', 'on' => ['usercreate']],
            [['username', 'password'], 'required', 'on' => ['sigin', 'register', 'usercreate']],
            [['password_confirmation'], 'required', 'on' => ['register', 'passwordchange', 'usercreate']],
            [['password', 'password_old'], 'required', 'on' => ['passwordchange']],
            [['password', 'password_confirmation'], 'string', 'min' => $this->_password_min_length],
            [['rememberMe'], 'boolean', 'on' => ['sigin']],
            [['email'], 'validateEmailOnCreate', 'on' => ['usercreate']],
            [['password'], 'validatePassword', 'on' => ['sigin']],
            [['password_old'], 'validateOLDPassword', 'on' => ['passwordchange']],
            [['email'], 'email', 'on' => ['remind', 'usercreate']],
            [['password_confirmation'], 'compare', 'compareAttribute' => 'password', 'on' => ['register', 'passwordchange', 'adminpasswordchange']],
            [['password', 'password_confirmation'], 'required', 'on' => ['adminpasswordchange']],
            [['captcha'], 'captcha', 'captchaAction' => '/user/login/captcha'],
            [['captcha'], 'required', 'on' => ['sigin']],
        ];
        if ($this->_username_attribute === 'email') {
            $r = ArrayHelper::merge($r, [
                        [['username'], 'email', 'on' => ['sigin', 'register']]
            ]);
        }

        return $r;
    }

    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'group_id' => Yii::t('app', 'group'),
            'published' => Yii::t('app', 'published'),
            'username' => Yii::t('user', 'username'),
            'password_old' => Yii::t('user', 'password_old'),
            'password' => Yii::t('user', 'password'),
            'password_confirmation' => Yii::t('user', 'password_confirmation'),
            'email' => Yii::t('user', 'email'),
            'rememberMe' => Yii::t('user', 'rememberMe'),
        ];
    }

    /**
     * 
     * @return array
     */
    public function scenarios() {
        return [
            'sigin' => ['username', 'password', 'rememberMe', 'captcha'],
            'register' => ['username', 'password', 'password_confirmation'],
            'usercreate' => ['username', 'email', 'password', 'password_confirmation', 'group_id'],
            'remind' => ['email'],
            'passwordchange' => ['password', 'password_confirmation', 'password_old'],
            'adminpasswordchange' => ['password', 'password_confirmation'],
        ];
    }

    /**
     *
     */
    public function validateEmailOnCreate() {
        if (!$this->hasErrors()) {
            $user = $this->getUserByEmail();
            if ($user !== null) {
                $this->addError('username', Yii::t('user', 'User exists'));
                $this->addError('email', Yii::t('user', 'User exists'));
            }
        }
    }

    /**
     * validate password_old on passwordchange scenario
     */
    public function validateOLDPassword() {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password_old)) {
                $this->addError('password_old', Yii::t('user', 'Incorrect password.'));
            }
        }
    }

    /**
     * validate password on sigin scenario
     */
    public function validatePassword() {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', Yii::t('user', 'Incorrect username or password.'));
            }
        }
    }

    /**
     *
     * @return boolean
     */
    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? $this->getTimeRememberUserSigin() : 0);
        } else {
            return false;
        }
    }

    /**
     *
     * @return User
     */
    public function getUser() {
        return ($this->_username_attribute === 'username') ? $this->getUserByUserName() : $this->getUserByEmail();
    }

    /**
     * Finds user by [[email]]
     * @return User|null
     */
    public function getUserByEmail() {
        if ($this->_user === null) {
            $email = ($this->_username_attribute === 'email') ? $this->username : $this->email;
            $this->_user = User::findByEmail($email);
        }
        return $this->_user;
    }

    /**
     * Finds user by [[username]]
     * @return User|null
     */
    public function getUserByUserName() {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }

    /**
     *
     * @return boolean
     */
    public function getAutoLoginAfterRegister() {
        return $this->_auto_login_after_register;
    }

    /**
     *
     */
    public function addFlash($value = true) {
        Yii::$app->getSession()->addFlash(self::FLASH_KEY, $value);
    }

    /**
     *
     * @return array
     */
    public function getFlash() {
        return Yii::$app->getSession()->getFlash(self::FLASH_KEY, '');
    }

    /**
     *
     * @return integer
     */
    public function getTimeRememberUserSigin() {
        return $this->_time_remember_user_sigin;
    }

}
