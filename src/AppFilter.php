<?php
/**
 *
 * @author: maxiaoxiong
 * @email: maxiaoxiong@xiaomi.com
 * time: 2018/9/3 下午5:54
 */
namespace larax\feature;

use yii\base\ActionFilter;

class AppFilter extends ActionFilter
{
    const SYSTEM_FUNCTION_USAGE_FREQUENCY_STATISTICS = 'system_function_usage_frequency_statistics';

    /**
     * 端口
     * @var
     */
    private $port;
    /**
     * @param $action
     * @return bool|void
     */
    public function beforeAction($action)
    {
        \Yii::$app->redis->lpush(static::SYSTEM_FUNCTION_USAGE_FREQUENCY_STATISTICS, $this->body());

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
            'input'         => \Yii::$app->request->bodyParams
        ]);
    }
}