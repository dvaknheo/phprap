<?php
namespace app\models\account;

use Yii;
use app\models\Account;
use app\models\Config;
use app\models\LoginLog;

class LoginForm extends Account
{
    public $email;
    public $password;
    public $verifyCode;
    public $callback;
    public $rememberMe = 1;

    public function rules()
    {
        return [
            [['email', 'verifyCode'], 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message' => '登录邮箱不能为空'],
            ['email', 'email','message' => '邮箱格式不合法'],
            ['rememberMe', 'boolean'],
            ['password', 'required', 'message' => '密码不可以为空'],
            ['verifyCode', 'required', 'message' => '验证码不能为空', 'when' => function($model, $attribute){
                return trim($model->verifyCode) ? true : false;
            }],
            ['verifyCode', 'captcha', 'captchaAction' => 'home/captcha/login', 'when' => function($model, $attribute){
                return trim($model->verifyCode) ? true : false;
            }],
            ['password', 'validatePassword'],

            ['callback', 'string', 'max' => 255],
        ];
    }

    /**
     * 验证密码是否正确
     * @param $attribute
     */
    public function validatePassword($attribute)
    {
        if (Account::validatePassword($this->email,$this->password)) {
            $this->addError($attribute, '登录邮箱或密码错误');
            return false;
        }

        if (!Account::validateActive($this->email)) {
            $this->addError($attribute, '抱歉，该账号已被禁用，请联系管理员处理');
            return false;
        }
    }

    /**
     * 用户登录
     * @return bool
     */
    public function login()
    {
        if(!$this->validate()){
            return false;
        }

        $account = Account::findByEmail($this->email);

        // 记录日志
        $loginLog = new LoginLog();
        $flag = $loginLog->createLoginLog($account->id, $account->name, $account->email);
        if(!$flag){
            $this->addError($loginLog->getErrorLabel(), $loginLog->getErrorMessage());
            return false;
        }
        
        $login_keep_time = Config::GetLoginKeepTime();
        return Yii::$app->user->login($account, 60*60*$login_keep_time);
    }

}
