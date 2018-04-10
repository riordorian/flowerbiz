<?

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;

AdminAsset::register($this);
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
</head>
<body class="<?=( !empty($this->context->bodyClass) ) ? $this->context->bodyClass : ''?>">
<?php $this->beginBody() ?>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <span>
<!--                            <img alt="image" class="img-circle" src="/assets/admin/img/logo.jpg" />-->
                        </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false" href="#">
                            <h2 class="clear"> <span class="block m-t-xs"> <strong class="font-bold">FlowerShop</strong><b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs"><?

                            if( Yii::$app->user->can('terminalWork') ){
                                ?><li><a href="/terminal/calendar/">Календарь</a></li>
                                <li><a href="/terminal/orders/">Терминал</a></li><?
                            }

                            ?><li class="divider"></li>
                            <li><a href="/logout/">Выход</a></li>
                        </ul>
                    </div>
                     <div class="logo-element profile-element">
	                     FSHOP
                    </div>
                    <!--<div class="logo-element">
                        <img alt="image" class="img-circle" src="/assets/admin/img/logo.jpg" />
                    </div>-->
                </li>


                <li class="active">
                    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Маркетинг</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="/admin/clients/">Клиенты</a></li>
                        <li><a href="/admin/clients-groups/">Группы клиентов</a></li>
<!--                        <li><a href="/admin/loyalty-programs/">Программы лояльности</a></li>-->
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-euro"></i> <span class="nav-label">Финансы</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="/admin/money-accounts/">Счета</a></li>
                        <li><a href="/admin/money-movements/">Операции</a></li>
                        <li><a href="/admin/cashboxes/">Кассы</a></li>
                        <li><a href="/admin/cash-periods/">Кассовые смены</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Каталог</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="/admin/catalog-sections/">Категории товаров</a></li>
                        <li><a href="/admin/catalog-products/">Товары</a></li>
                        <li><a href="/admin/good-supply/">Поставки</a></li>
                        <li><a href="/admin/good-writes-off/">Списания товара</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/site/reports/"><i class="fa fa-table"></i> <span class="nav-label">Отчеты</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="/admin/orders/">Продажи</a></li>
                        <li><a href="/admin/reports/salaries/">Зарплаты</a></li>
                        <li><a href="/admin/reports/profit/">Прибыль</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-book"></i> <span class="nav-label">Справочники</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li class=""><a href="/admin/clients-types/">Типы клиентов</a></li>
                        <li class=""><a href="/admin/events/">Типы событий</a></li>
                        <li class=""><a href="/admin/gift-recipients/">Типы получателей</a></li>
                        <li class=""><a href="/admin/providers/">Поставщики</a></li>
                    </ul>
                </li>
                <li class="<?= !Yii::$app->user->can('userView') ? 'hidden' : ''?>">
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">Пользователи</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li class=""><a href="/admin/operators/">Флористы</a></li>
                        <li class="<?= !Yii::$app->user->can('managerView') ? 'hidden' : ''?>"><a href="/admin/managers/">Администраторы</a></li>
                    </ul>
                </li>
            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right"><?
                    if( Yii::$app->user->isGuest ){
                        ?><li>
                            <a href="/auth/">
                                Вход
                            </a>
                        </li>
                        <li>
                            <a href="/registration/">
                                Регистрация
                            </a>
                        </li><?
                    }
                    else{
                        ?>
                        <li><span><?=Yii::$app->user->identity->username?></span></li>
                        <li>
                            <a href="/logout/">
                                <i class="fa fa-sign-out"></i> Выход
                            </a>
                        </li><?
                    }
                    ?></ul>

            </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading js-page-heading" data-fix-heading="<?=( !empty($this->context->fixHeading) ) ? $this->context->fixHeading : false?>">
            <div class="col-lg-10">
                <h1><?=Html::encode($this->title)?> <?=( !empty($this->context->listCount) ) ? '(' . $this->context->listCount . ')' : ''?></h1>

                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'homeLink' => ['label' => 'Главная', 'url' => '/admin/'],
                    'activeItemTemplate' => "<li class=\"active\"><strong>{link}</strong></li>\n",
                    'tag' => 'ol'
                ]) ?>
            </div>
            <div class="col-lg-2 js-page-heading__additional"></div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content">
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="pull-right">
            </div>
            <div>
                <strong>Copyright</strong> FLOWERBIZ 2017 - <?=date('Y')?>
            </div>
        </div>

    </div>
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
