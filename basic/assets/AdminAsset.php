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
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/assets/admin/css/bootstrap.css?1',
        '/assets/admin/css/loader.css',
        '/assets/admin/css/animate.css',

        /*CHOSEN*/
        '/assets/admin/css/plugins/chosen/chosen.css',
        '/assets/admin/css/plugins/chosen/bootstrap-chosen.css',

        /*DATAPICKER*/
        '/assets/admin/css/plugins/datepicker/datepicker3.css',
        '/assets/admin/css/plugins/datepicker/datetimepicker.css',

        /*ICHEK*/
        '/assets/admin/css/plugins/iCheck/custom.css',

        /*SWITCHER*/
        '/assets/admin/css/plugins/switchery/switchery.css',

        /*MAGNIFIC-POPUP*/
        '/assets/admin/css/plugins/mgnfc-popup/magnific-popup.css',

        '/assets/admin/font-awesome/css/font-awesome.css',
        '/assets/admin/css/style.css',
        '/assets/admin/css/custom.css',
    ];
    public $js = [
        'assets/admin/js/bootstrap.js',

        'assets/admin/js/plugins/metisMenu/jquery.metisMenu.js',

        /*CHOSEN*/
        'assets/admin/js/plugins/chosen/chosen.jquery.js',

        /*ICHECK*/
        'assets/admin/js/plugins/iCheck/icheck.min.js'
        ,
        'assets/admin/js/plugins/slimscroll/jquery.slimscroll.min.js',
//        'assets/admin/js/plugins/pace/pace.min.js',

        /*DATEPICKER*/
        'assets/admin/js/plugins/datepicker/bootstrap-datepicker.js',

        /*DATETIMEPICKER*/
        'assets/admin/js/moment.js',
        'assets/admin/js/plugins/datepicker/datetimepicker.js',

        /*MASKED INPUT*/
        'assets/admin/js/plugins/jasny/jasny-bootstrap.min.js',

        /*SWITCHER*/
        'assets/admin/js/plugins/switchery/switchery.js',

        /*MAGNIFIC-POPUP*/
        'assets/admin/js/plugins/mgnfc-popup/jquery.magnific-popup.js',
        '/assets/admin/css/plugins/mgnfc-popup/magnific-popup-custom.css',

        'assets/admin/js/inspinia.js',
        'assets/admin/js/crm.js',
        'assets/admin/js/admin.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
