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
        '/assets/admin/css/bootstrap.css?2',
        '/assets/admin/css/loader.css',

        /*CHOSEN*/
        '/assets/admin/css/plugins/chosen/chosen.css',
        '/assets/admin/css/plugins/chosen/bootstrap-chosen.css',

        /*SWITCHER*/
        '/assets/admin/css/plugins/switchery/switchery.css',

        /*CLOCKPICKER*/
        'assets/admin/css/plugins/clockpicker/clockpicker.css',

        '/assets/admin/font-awesome/css/font-awesome.css',

        /*MAGNIFIC-POPUP*/
        '/assets/admin/css/plugins/mgnfc-popup/magnific-popup.css',
        '/assets/admin/css/plugins/mgnfc-popup/magnific-popup-custom.css',

        /*FULL CALENDAR*/
        '/assets/terminal/css/fullcalendar/fullcalendar.css',
        '/assets/terminal/css/fullcalendar/fullcalendar.adaptive.css',

        '/assets/admin/css/style.css',
        '/assets/terminal/css/style.css?',
        '/assets/terminal/css/responsive.css?',

    ];
    public $js = [
        /*CHOSEN*/
        'assets/admin/js/plugins/chosen/chosen.jquery.js',

        /*SWITCHER*/
        'assets/admin/js/plugins/switchery/switchery.js',

        /*AUTOCOMPLETE*/
        'assets/terminal/js/typeahead/typeahead.min.js',
        
        /*CLOCKPICKER*/
        'assets/admin/js/plugins/clockpicker/clockpicker.js',

        /*MAGNIFIC-POPUP*/
        'assets/admin/js/plugins/mgnfc-popup/jquery.magnific-popup.js',

        /*MASKED INPUT*/
        'assets/admin/js/plugins/jasny/jasny-bootstrap.min.js',

        'assets/admin/js/bootstrap.js',
        'assets/terminal/js/fullcalendar/moment.min.js',
        'assets/terminal/js/fullcalendar/fullcalendar.min.js',
        'assets/terminal/js/fullcalendar/ru.js',
        'assets/terminal/js/fullcalendar/gcal.js',
        'assets/admin/js/crm.js',
        'assets/terminal/js/terminal.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
