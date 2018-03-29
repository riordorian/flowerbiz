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
        '/admin/css/bootstrap.css?1',
        '/admin/css/loader.css',
        '/admin/css/animate.css',

        /*CHOSEN*/
        '/admin/css/plugins/chosen/chosen.css',
        '/admin/css/plugins/chosen/bootstrap-chosen.css',

        /*DATAPICKER*/
        '/admin/css/plugins/datepicker/datepicker3.css',
        '/admin/css/plugins/datepicker/datetimepicker.css',

        /*ICHEK*/
        '/admin/css/plugins/iCheck/custom.css',

        /*SWITCHER*/
        '/admin/css/plugins/switchery/switchery.css',

        /*MAGNIFIC-POPUP*/
        '/admin/css/plugins/mgnfc-popup/magnific-popup.css',

        '/admin/font-awesome/css/font-awesome.css',
        '/admin/css/style.css',
        '/admin/css/custom.css',
    ];
    public $js = [
        '/admin/js/bootstrap.js',

        '/admin/js/plugins/metisMenu/jquery.metisMenu.js',

        /*CHOSEN*/
        '/admin/js/plugins/chosen/chosen.jquery.js',

        /*ICHECK*/
        '/admin/js/plugins/iCheck/icheck.min.js'
        ,
        '/admin/js/plugins/slimscroll/jquery.slimscroll.min.js',
//        '/admin/js/plugins/pace/pace.min.js',

        /*DATEPICKER*/
        '/admin/js/plugins/datepicker/bootstrap-datepicker.js',

        /*DATETIMEPICKER*/
        '/admin/js/moment.js',
        '/admin/js/plugins/datepicker/datetimepicker.js',

        /*MASKED INPUT*/
        '/admin/js/plugins/jasny/jasny-bootstrap.min.js',

        /*SWITCHER*/
        '/admin/js/plugins/switchery/switchery.js',

        /*MAGNIFIC-POPUP*/
        '/admin/js/plugins/mgnfc-popup/jquery.magnific-popup.js',
        '/admin/css/plugins/mgnfc-popup/magnific-popup-custom.css',

        '/admin/js/inspinia.js',
        '/admin/js/crm.js',
        '/admin/js/admin.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
