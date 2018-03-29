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
class TerminalAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/admin/css/bootstrap.css?2',
        '/admin/css/loader.css',

        /*CHOSEN*/
        '/admin/css/plugins/chosen/chosen.css',
        '/admin/css/plugins/chosen/bootstrap-chosen.css',

        /*SWITCHER*/
        '/admin/css/plugins/switchery/switchery.css',

        /*CLOCKPICKER*/
        '/admin/css/plugins/clockpicker/clockpicker.css',

        '/admin/font-awesome/css/font-awesome.css',

        /*MAGNIFIC-POPUP*/
        '/admin/css/plugins/mgnfc-popup/magnific-popup.css',
        '/admin/css/plugins/mgnfc-popup/magnific-popup-custom.css',

        /*FULL CALENDAR*/
        '/terminal/css/fullcalendar/fullcalendar.css',
        '/terminal/css/fullcalendar/fullcalendar.adaptive.css',

        '/admin/css/style.css',
        '/terminal/css/style.css?',
        '/terminal/css/responsive.css?',

    ];
    public $js = [
        /*CHOSEN*/
        '/admin/js/plugins/chosen/chosen.jquery.js',

        /*SWITCHER*/
        '/admin/js/plugins/switchery/switchery.js',

        /*AUTOCOMPLETE*/
        '/terminal/js/typeahead/typeahead.min.js',
        
        /*CLOCKPICKER*/
        '/admin/js/plugins/clockpicker/clockpicker.js',

        /*MAGNIFIC-POPUP*/
        '/admin/js/plugins/mgnfc-popup/jquery.magnific-popup.js',

        /*MASKED INPUT*/
        '/admin/js/plugins/jasny/jasny-bootstrap.min.js',

        '/admin/js/bootstrap.js',
        '/terminal/js/fullcalendar/moment.min.js',
        '/terminal/js/fullcalendar/fullcalendar.min.js',
        '/terminal/js/fullcalendar/ru.js',
        '/terminal/js/fullcalendar/gcal.js',
        '/admin/js/crm.js',
        '/terminal/js/terminal.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
