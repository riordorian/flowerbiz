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
        '/assets/admin/css/bootstrap.css?1',
        '/assets/admin/css/loader.css',

        '/assets/admin/font-awesome/css/font-awesome.css',
        '/assets/terminal-login/css/style.css',
    ];
    public $js = [
        'assets/admin/js/bootstrap.js',
        'assets/admin/js/crm.js',
        'assets/terminal-login/js/login.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
