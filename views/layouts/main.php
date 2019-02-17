<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
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

    <!--
    @import url();
    <?php $this->registerCssFile("@web/css/style.css");?>
    <?php $this->registerJsFile("@web/js/jquery-3.3.1.min.js");?>
    <?php $this->registerJsFile("@web/js/layer/layer.js");?>
    -->
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'WindBlog',
//        'brandUrl' => 'https://walkingsun.github.io/WindBlog/',    //Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => '技术文章', 'url' => ['/index/index']],
            ['label' => '博客自动化', 'url' => ['/metaweblog/index']],
            ['label' => '知识复盘', 'url' => ['/recovery/index']],
            '<li><a id="wbcontact">关于</a></li>',
            '<li><a id="im">Simple IM</a></li>',
            ['label' => '联系', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => '登录', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    '退出 (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<!--<footer class="footer">-->
<!--    <div class="container">-->
<!--        <p class="pull-left">&copy;WalkingSun  --><?//= date('Y') ?><!--</p>-->
<!---->
<!--        <p class="pull-right">--><?//= Yii::powered() ?><!--</p>-->
<!--    </div>-->
<!--</footer>-->

<?php $this->endBody() ?>
</body>
<script>
    $("#wbcontact").click(function(){
        window.open('https://github.com/WalkingSun/WindBlog/blob/master/README.md');
    })

    $(".navbar-brand").click(function(){
        window.open('https://walkingsun.github.io/WindBlog/');
    })
    $("#im").click(function(){
        window.open('http://47.99.189.105:91');
    })
</script>
</html>
<?php $this->endPage() ?>
