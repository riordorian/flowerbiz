<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TerminalLoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/admin/css/bootstrap.css?1',
        '/admin/css/loader.css',

        '/admin/font-awesome/css/font-awesome.css',
        '/terminal-login/css/style.css',
    ];
    public $js = [
        '/admin/js/bootstrap.js',
        '/admin/js/crm.js',
        '/terminal-login/js/login.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
