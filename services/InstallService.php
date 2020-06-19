<?php
namespace app\services;

use Yii;
use yii\db\Exception;
use app\models\Member;
use app\models\Account;
use app\models\LoginLog;

class InstallService extends BaseService
{
    public function isInstalled()
    {
        return InstallLib::G()->isInstalled();
    }
    public function getInstallTime()
    {
        return InstallLib::G()->getInstallTime();
    }
    public function getAppVersion()
    {
        return Yii::$app->params['app_version'];
    }
    public function step1()
    {
        $step1 = [
            'runtime' => [
                'have_chmods'    => $this->getChmodsLabel(Yii::getAlias("@runtime")),
                'require_chmods' => '可读、可写',
                'check_chmod'    => is_writable(Yii::getAlias("@runtime")),
            ],
            'runtime/cache' => [
                'have_chmods'    => $this->getChmodsLabel(Yii::getAlias("@runtime") . '/cache'),
                'require_chmods' => '可读、可写',
                'check_chmod'    => is_writable(Yii::getAlias("@runtime") . '/cache'),
            ],
            'runtime/install' => [
                'have_chmods'    => $this->getChmodsLabel(Yii::getAlias("@runtime") . '/install'),
                'require_chmods' => '可读、可写',
                'check_chmod'    => is_writable(Yii::getAlias("@runtime") . '/install'),
            ],
            'configs/db.php' => [
                'have_chmods'    => $this->getChmodsLabel(Yii::getAlias("@app") . '/configs/db.php'),
                'require_chmods' => '可读、可写',
                'check_chmod'    => is_writable(Yii::getAlias("@app") . '/configs/db.php'),
            ],
        ];
        return $step1;
    }
    // 获取权限
    private function getChmodsLabel($dirName)
    {
        $chmod = '';

        is_readable ($dirName) && $chmod = '可读、';
        is_writable ($dirName) && $chmod .= '可写、';
        is_executable ($dirName) && $chmod .= '可执行、';

        return trim($chmod, '、');
    }
    public function step2($step2)
    {
        $db = [
            'dsn'      => "mysql:host={$step2['host']};port={$step2['port']}}",
            'username' => $step2['username'],
            'password' => $step2['password'],
            'charset'  => 'utf8',
        ];

        // 判断数据库连接状态
        $connection = new \yii\db\Connection($db);

        try {
            $connection->open();
        } catch(Exception $e) {
            throw new \Exception('数据库连接失败，请检查数据库配置信息是否正确');
        }

        if(!$connection->isActive){
            throw new \Exception('当前数据库连接处于非激活状态，请检查PDO安装是否正确');
        }

        // 创建数据库
        $sql = "CREATE DATABASE IF NOT EXISTS {$step2['dbname']} CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';";

        if(!$connection->createCommand($sql)->execute()){
            throw new \Exception("数据库 {$step2['dbname']} 创建失败，没有创建数据库权限，请手动创建数据库");
        }

        $db['dsn']         = "mysql:host={$step2['host']};port={$step2['port']};dbname={$step2['dbname']}";
        $db['tablePrefix'] = $step2['prefix'];
        $db = ['class' => 'yii\db\Connection'] + $db;

        $config = "<?php\r\nreturn\n" . var_export($db,true) . "\r\n?>";

        // 将数据库配置信息写入配置文件
        if(file_put_contents(Yii::getAlias("@app") . '/configs/db.php', $config) === false){
            throw new \Exception('数据库配置文件写入错误，请检查configs/db.php文件是否有可写权限');
        }
        return true;
    }
    public function step3($step3)
    {
        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();

        try {
            // 数据库初始化
            $init_sql = $this->getInitSql();
            Yii::$app->db->createCommand($init_sql)->execute();

            // 插入管理员
            $account = new Account();
            if(!$account->createAccount($step3['name'],$step3['email'],$step3['password'])){
                $transaction->rollBack();
                return ['status' => 'error', 'message' => $account->getErrorMessage(), 'label' => $account->getErrorLabel()];
            }

            // 默认加入测试项目
            $member = new Member();
            if(!$member->createMember($account->id)){
                $transaction->rollBack();
                return ['status' => 'error', 'message' => $member->getErrorMessage(), 'label' => $member->getErrorLabel()];
            }

            // 记录日志
            $loginLog = new LoginLog();
            if(!$loginLog->createLoginLog($account->id, $account->name, $account->email)){
                $transaction->rollBack();
                return ['status' => 'error', 'message' => $loginLog->getErrorMessage(), 'label' => $loginLog->getErrorLabel()];
            }

            // 事务提交
            $transaction->commit();

            // 保存登录状态
            $login_keep_time = config('login_keep_time', 'safe');

            Yii::$app->user->login($account, 60*60*$login_keep_time);
            
            return ['status' => 'success', 'callback' => url('home/install/step4')];

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
    public function step4()
    {
        // 创建安装锁文件
        if(file_put_contents(Yii::getAlias("@runtime") . '/install/install.lock', json_encode(['installed_at' => date('Y-m-d H:i:s')])) === false){
            throw new \Exception('数据库锁文件写入错误，请检查 runtime/install 文件夹是否有可写权限');
        }

        // 获取所有数据表
        $sql = "show tables";
        $tables = Yii::$app->db->createCommand($sql)->queryColumn();
        
        return $tables;
        
    }
    // 获取安装初始化sql语句
    private function getInitSql()
    {
        // 读取初始化数据库脚本文件内容
        $lines = file(Yii::getAlias("@runtime") .'/install/db.sql');
        $sql = "";
        // 循环排除掉不合法的sql语句
        foreach($lines as $line){
            $line = trim($line);
            if($line != ""){
                if(!($line{0} == "#" || $line{0}.$line{1} == "--")){
                    // 将表前缀替换成自定义前缀
                    $line = str_replace("doc_", Yii::$app->db->tablePrefix, $line);
                    $sql .= $line;
                }
            }
        }

        return $sql;
    }
    

}