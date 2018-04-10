<?

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\TerminalAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

TerminalAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

	<!-- Yandex.Metrika counter -->
	<script type="text/javascript" >
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter48429272 = new Ya.Metrika({
                        id:48429272,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
	</script>
	<noscript><div><img src="https://mc.yandex.ru/watch/48429272" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->
</head>

<body class="<?=( !empty($this->context->bodyClass) ) ? $this->context->bodyClass : ''?>">
<?php $this->beginBody() ?>

<div class="terminal__info p-h-xxs bg-muted border-bottom">
    <div class="col-md-3 col-sm-4 col-xs-4">
        <a class="navbar-minimalize btn btn-primary js-widget popover-widget" href="javascript:;" data-toggle="popover" data-placement="auto right" data-popover-content="#terminal-menu"><i class="fa fa-bars"></i> </a>
        <div id="terminal-menu" class="hidden">
            <p><a class="text-navy" href="/terminal/calendar/"><i class="fa fa-calendar m-r-xs"></i>Календарь</a></p>
            <p><a class="text-navy" href="/terminal/orders/"><i class="fa fa-shopping-cart m-r-xs"></i>Терминал</a></p>
            <p><a class="text-navy" href="/logout/"><i class="fa fa-sign-out m-r-xs"></i>Сменить оператора</a></p><?

            if( !empty(Yii::$app->params['OPENED_PERIODS']) ){
                ?><p>
                    <a class="text-navy js-ajax-link" data-reload="true" href="/admin/cash-periods/close/?id=<?=reset(Yii::$app->params['OPENED_PERIODS'])['ID']?>"><i class="fa fa-lock m-r-xs"></i>Закрыть смену</a>
                </p><?
            }
            ?>

            <hr><?
            if( Yii::$app->user->can('adminWork') ){
                ?><p><a class="text-navy" href="/admin/clients/"><i class="fa fa-tachometer m-r-xs"></i> Административный раздел</a></p><?
            }
        ?></div>
    </div>
    <div class="col-md-5 col-sm-4 col-xs-4 text-center hidden-xs">
        <div class="btn-group">
            <a href="/terminal/calendar/" class="btn btn-<?=Url::current() == '/terminal/calendar/' ? 'primary' : 'white'?>" type="button">Календарь</a>
            <a href="/terminal/orders/" class="btn btn-<?=Url::current() == '/terminal/orders/' ? 'primary' : 'white'?>" type="button">Товары</a>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-4 pull-right text-right">
        <p class="p-xxs m-n"><a class="text-navy" href="/logout/"><i class="fa fa-sign-out m-r-xs"></i><?=Yii::$app->user->identity->username?></a></p>
    </div>
    <div class="clearfix"></div>
</div>


<div class="terminal__content">
    <?= $content ?>
</div>

<?php $this->endBody() ?>

<script data-skip-moving="true">
    (function(w,d,u){
        var s=d.createElement('script');s.async=1;s.src=u+'?'+(Date.now()/60000|0);
        var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
    })(window,document,'https://cdn.bitrix24.ru/b6740583/crm/site_button/loader_2_oppkio.js');
</script>
</body>
</html>
<?php $this->endPage() ?>
