<?php
namespace app\models;

use Yii;
use app\widgets\LinkPager;
use yii\data\Pagination;
use Jenssegers\Agent\Agent;

/**
 * This is the model class for table "{{%login_log}}".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property string $user_name 用户名称
 * @property string $user_email 用户邮箱
 * @property string $ip 登录ip
 * @property string $location 登录地址
 * @property string $browser 浏览器
 * @property string $os 操作系统
 * @property string $created_at 登录时间
 * @property string $updated_at 更新时间
 */
class LoginLog extends Model
{
    /**
     * 绑定数据表
     */
    public static function tableName()
    {
        return '{{%login_log}}';
    }

    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            [['user_name', 'user_email', 'ip'], 'required'],

            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_name', 'user_email', 'ip'], 'string', 'max' => 50],
            [['location'], 'string', 'max' => 255],
            [['browser', 'os'], 'string', 'max' => 250],
        ];
    }

    /**
     * 字段标签
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'user_name' => '用户名称',
            'user_email' => '用户邮箱',
            'ip' => '登录ip',
            'location' => '登录地址',
            'browser' => '浏览器',
            'os' => '操作系统',
            'created_at' => '登录时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取关联用户对象
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(),['id'=>'user_id']);
    }

    /**
     * 登录历史搜索
     * @param array $params
     * @return $this
     * @throws \Exception
     */
    public function search($params = [])
    {
        $this->params = array2object($params);

        $query = self::find();

        $query->andFilterWhere([
            'user_id' => $this->params->user_id,
        ]);

        $query->andFilterWhere(['like', 'ip', trim($this->params->ip)]);
        $query->andFilterWhere(['like', 'location', trim($this->params->location)]);

        // 账号/昵称搜索
        if($this->params->user){

            $query->andFilterWhere([
                    'or',
                    ['like','user_name', trim($this->params->user->name)],
                    ['like','user_email', trim($this->params->user->name)],
                ]);
        }

        $this->count = $query->count();

        $pagination = new Pagination([
            'pageSizeParam' => false,
            'totalCount' => $this->count,
            'pageSize'   => $this->pageSize,
            'validatePage' => false,
        ]);

        $this->models = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('id DESC')
            ->all();

        $this->sql = $query->createCommand()->getRawSql();

        $this->pages = LinkPager::widget([
            'pagination' => $pagination,
            'nextPageLabel' => '下一页',
            'prevPageLabel' => '上一页',
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
            'hideOnSinglePage' => true,
            'maxButtonCount' => 5,
        ]);
        //return [$params,$];
        return $this;
    }
    public function createLoginLog($id,$name,$email)
    {
        $this->user_id    = $id;
        $this->user_name  = $name;
        $this->user_email = $email;
        
        $this->ip         = $this->getUserIp();
        $this->location   = $this->getLocation();
        $this->browser    = $this->getBrowser();
        $this->os         = $this->getOs();
        $this->created_at = date('Y-m-d H:i:s');

        return $this->save();
    }
    /**
     * 获取访问者浏览器
     * @return string
     */
    protected function getBrowser()
    {
        $agent = new Agent();

        $browser = $agent->browser();
        $version = $agent->version($browser);

        return $browser . '(' . $version . ')';
    }
    /**
     * 获取访问者的操作系统
     * @return string
     */
    protected function getOs()
    {
        $agent = new Agent();

        $platform = $agent->platform();
        $version  = $agent->version($platform);

        return $platform . '(' . $version . ')';
    }
}