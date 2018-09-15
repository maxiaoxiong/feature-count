<?php
/**
 *
 * @author: maxiaoxiong
 * @email: maxiaoxiong@xiaomi.com
 * time: 2018/9/3 下午5:54
 */
namespace larax\feature;

use yii\base\ActionFilter;
use yii\redis\Connection;

class AppFilter extends ActionFilter
{
    const SYSTEM_FUNCTION_USAGE_FREQUENCY_STATISTICS = 'system_function_usage_frequency_statistics';

    /**
     * 系统代号
     * @var string $systemCode
     */
    public $systemCode;

    /**
     * Redis 配置
     * @var array $config
     */
    public $config;

    /**
     * redis实例
     */
    public $redis;

    /**
     * 请求参数
     * @var array $request
     */
    public $request;

    public function __construct()
    {
        parent::__construct();
        $this->config = config();
        $this->setRedis($this->config);
    }

    /**
     * @param $action
     * @return bool|void
     */
    public function beforeAction($action)
    {
        $this->redis->open();
        $this->redis->lpush(static::SYSTEM_FUNCTION_USAGE_FREQUENCY_STATISTICS, $this->body());
        $this->redis->close();

        return parent::beforeAction($action);
    }

    /**
     * 暂时用不上
     * @param $action
     * @param $result
     * @return bool|mixed
     */
    public function afterAction($action, $result)
    {
        return parent::afterAction($action, $result);
    }

    private function body()
    {
        return json_encode([
            'system_code'   => $this->systemCode,
            'uid'           => \Yii::$app->user->id,
            'url'           => \Yii::$app->request->url,
            'absolute_url'  => \Yii::$app->request->absoluteUrl,
            'host_info'     => \Yii::$app->request->hostInfo,
            'base_info'     => \Yii::$app->request->baseUrl,
            'script_url'    => \Yii::$app->request->scriptUrl,
            'method'        => \Yii::$app->request->method,
            'path_info'     => \Yii::$app->request->pathInfo,
            'ip'            => \Yii::$app->request->userIP,
            'port'          => \Yii::$app->request->port,
            'query_string'  => \Yii::$app->request->queryString,
            'input'         => \Yii::$app->request->bodyParams,
            'time'          => date('Y-m-d H:i:s')
        ]);
    }


    /**
     * @param mixed $config
     */
    public function setRedis($config)
    {

        // 初始化 redis 实例
        $this->redis = new Connection();
        $this->redis->hostname = $config['host'];
        $this->redis->port = $config['port'];
        if (!empty($config['auth'])) {
            $this->redis->password = $config['auth'];
        }
    }


}