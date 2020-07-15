<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_config".
 *
 * @property int $id
 * @property string $type 配置类型
 * @property string $content 配置内容
 * @property string $created_at
 * @property string $updated_at
 */
class Config extends Model
{
    /**
     * 绑定数据表
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['type', 'content'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['type'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * 获取不存在字段
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (!$this->hasAttribute($name)) {
            $config = json_decode($this->content);
            return $config->$name;
        }
        return parent::__get($name);
    }
    public static function GetLoginKeepTime()
    {
        Config::findOne(['type' => 'safe']);
        return $config->login_keep_time;
    }
    public static function validateToken($registerToken)
    {
        $config = Config::findOne(['type' => 'safe']);

        if (!$config->register_token || $config->register_token != $registerToken) {
            $this->addError($attribute, '注册邀请码错误');
            return false;
        }
        return true;
    }
    public static function validateEmail($email)
    {

        $config = Config::findOne(['type' => 'safe']);

        $email_white_list = array_filter(explode("\r\n", trim($config->email_white_list)));
        $email_black_list = array_filter(explode("\r\n", trim($config->email_black_list)));

        // 获取邮箱后缀，如@phprap.com
        $register_email_suffix = stristr($email, "@");

        if($email_white_list && !in_array($register_email_suffix, $email_white_list)){
            $this->addError($attribute, '该邮箱后缀不在可注册名单中');
            return [false,true];
        }

        if($email_black_list && in_array($register_email_suffix, $email_black_list)){
            $this->addError($attribute, '该邮箱后缀不允许注册');
            return [true,false];
        }
        return [true,true];
    }
}
