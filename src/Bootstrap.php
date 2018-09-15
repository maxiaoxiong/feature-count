<?php
/**
 *
 * @author: maxiaoxiong
 * @email: maxiaoxiong@xiaomi.com
 * time: 2018/9/15 下午3:06
 */

namespace larax\feature;

use yii\base\Application;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
//            $this->bootstrap()
        }
    }
}