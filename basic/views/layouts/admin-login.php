<?php

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
<body class="gray-bg">
<?php $this->beginBody() ?>
<h1 class="logo-name text-center">FlowerShop</h1>
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <h3>Welcome to FlowerShop</h3>

        <?=$content?>

        <p class="m-t"> <small>FlowerShop &copy; 2016 - <?=date('Y')?></small> </p>
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
