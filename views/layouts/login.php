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
<!--    --><?php //$this->head() ?>

    <!--
    @import url();
    <?php $this->registerCssFile("@web/css/style.css");?>
    -->

    <?php echo Html::cssFile("@web/css/normalize.css");?>
    <?php echo Html::cssFile("@web/css/login.css");?>
    <?php echo Html::cssFile("@web/css/sign-up-login.css");?>
    <?php echo Html::cssFile("@web/css/font-awesome.min.css");?>
    <?php echo Html::cssFile("@web/css/inputEffect.css");?>
    <?php echo Html::cssFile("@web/css/tooltips.css");?>
    <?php echo  Html::cssFile("@web/css/spop.min.css");?>
    <?php echo  Html::jsFile("@web/js/jquery.min.js");?>
    <?php  echo Html::jsFile("@web/js/snow.js");?>
    <?php  echo Html::jsFile("@web/js/jquery.pure.tooltips.js");?>
    <?php  echo Html::jsFile("@web/js/spop.min.js");?>
    <?php  echo Html::jsFile("@web/js/layer/layer.js");?>

    <script>
        (function() {
            // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
            if (!String.prototype.trim) {
                (function() {
                    // Make sure we trim BOM and NBSP
                    var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
                    String.prototype.trim = function() {
                        return this.replace(rtrim, '');
                    };
                })();
            }

            [].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
                // in case the input is already filled..
                if( inputEl.value.trim() !== '' ) {
                    classie.add( inputEl.parentNode, 'input--filled' );
                }

                // events:
                inputEl.addEventListener( 'focus', onInputFocus );
                inputEl.addEventListener( 'blur', onInputBlur );
            } );

            function onInputFocus( ev ) {
                classie.add( ev.target.parentNode, 'input--filled' );
            }

            function onInputBlur( ev ) {
                if( ev.target.value.trim() === '' ) {
                    classie.remove( ev.target.parentNode, 'input--filled' );
                }
            }
        })();

        $(function() {
            $('#login #login-password').focus(function() {
                $('.login-owl').addClass('password');
            }).blur(function() {
                $('.login-owl').removeClass('password');
            });
            $('#login #register-password').focus(function() {
                $('.register-owl').addClass('password');
            }).blur(function() {
                $('.register-owl').removeClass('password');
            });
            $('#login #register-repassword').focus(function() {
                $('.register-owl').addClass('password');
            }).blur(function() {
                $('.register-owl').removeClass('password');
            });
            $('#login #forget-password').focus(function() {
                $('.forget-owl').addClass('password');
            }).blur(function() {
                $('.forget-owl').removeClass('password');
            });
        });

        function goto_register(){
            $("#register-username").val("");
            $("#register-password").val("");
            $("#register-repassword").val("");
            $("#register-code").val("");
            $("#tab-2").prop("checked",true);
        }

        function goto_login(){
            $("#login-username").val("");
            $("#login-password").val("");
            $("#tab-1").prop("checked",true);
        }

        function goto_forget(){
            $("#forget-username").val("");
            $("#forget-password").val("");
            $("#forget-code").val("");
            $("#tab-3").prop("checked",true);
        }

        function login(){//登录
            var username = $("#login-username").val(),
                password = $("#login-password").val(),
                validatecode = null,
                flag = false;
            //判断用户名密码是否为空
            if(username == ""){
                $.pt({
                    target: $("#login-username"),
                    position: 'r',
                    align: 't',
                    width: 'auto',
                    height: 'auto',
                    content:"用户名不能为空"
                });
                flag = true;
            }
            if(password == ""){
                $.pt({
                    target: $("#login-password"),
                    position: 'r',
                    align: 't',
                    width: 'auto',
                    height: 'auto',
                    content:"密码不能为空"
                });
                flag = true;
            }
            //用户名只能是15位以下的字母或数字
            var regExp = new RegExp("^[a-zA-Z0-9_]{1,15}$");
            if(!regExp.test(username)){
                $.pt({
                    target: $("#login-username"),
                    position: 'r',
                    align: 't',
                    width: 'auto',
                    height: 'auto',
                    content:"用户名必须为15位以下的字母或数字"
                });
                flag = true;
            }

            if(flag){
                return false;
            }else{//登录
                //调用后台登录验证的方法
                $.post('<?=\yii\helpers\Url::toRoute('/site/login')?>',{username:username,password:password},function(r){
                    console.log(r.code);
                    if(r.code!='200'){
                        layer.msg('帐号或密码错误');return false;
                    }else{
                        layer.msg('登录成功');
                        location.href='<?=\yii\helpers\Url::toRoute('/metaweblog/index')?>';
                    }
                },'json');

                return false;
            }
        }

        //注册
        function register(){
            var username = $("#register-username").val(),
                password = $("#register-password").val(),
                repassword = $("#register-repassword").val(),
                code = $("#register-code").val(),
                flag = false,
                validatecode = null;
            //判断用户名密码是否为空
            if(username == ""){
                $.pt({
                    target: $("#register-username"),
                    position: 'r',
                    align: 't',
                    width: 'auto',
                    height: 'auto',
                    content:"用户名不能为空"
                });
                flag = true;
            }
            if(password == ""){
                $.pt({
                    target: $("#register-password"),
                    position: 'r',
                    align: 't',
                    width: 'auto',
                    height: 'auto',
                    content:"密码不能为空"
                });
                flag = true;
            }else{
                if(password != repassword){
                    $.pt({
                        target: $("#register-repassword"),
                        position: 'r',
                        align: 't',
                        width: 'auto',
                        height: 'auto',
                        content:"两次输入的密码不一致"
                    });
                    flag = true;
                }
            }
            //用户名只能是15位以下的字母或数字
            var regExp = new RegExp("^[a-zA-Z0-9_]{1,15}$");
            if(!regExp.test(username)){
                $.pt({
                    target: $("#register-username"),
                    position: 'r',
                    align: 't',
                    width: 'auto',
                    height: 'auto',
                    content:"用户名必须为15位以下的字母或数字"
                });
                flag = true;
            }
            //检查用户名是否已经存在
            //调后台代码检查用户名是否已经被注册

            //检查注册码是否正确
            //调后台方法检查注册码，这里写死为11111111
            if(code != '11111111'){
                $.pt({
                    target: $("#register-code"),
                    position: 'r',
                    align: 't',
                    width: 'auto',
                    height: 'auto',
                    content:"注册码不正确"
                });
                flag = true;
            }


            if(flag){
                return false;
            }else{//注册
                spop({
                    template: '<h4 class="spop-title">注册成功</h4>即将于3秒后返回登录',
                    position: 'top-center',
                    style: 'success',
                    autoclose: 3000,
                    onOpen : function(){
                        var second = 2;
                        var showPop = setInterval(function(){
                            if(second == 0){
                                clearInterval(showPop);
                            }
                            $('.spop-body').html('<h4 class="spop-title">注册成功</h4>即将于'+second+'秒后返回登录');
                            second--;
                        },1000);
                    },
                    onClose : function(){
                        goto_login();
                    }
                });
                return false;
            }
        }

        //重置密码
        function forget(){
            var username = $("#forget-username").val(),
                password = $("#forget-password").val(),
                code = $("#forget-code").val(),
                flag = false,
                validatecode = null;
            //判断用户名密码是否为空
            if(username == ""){
                $.pt({
                    target: $("#forget-username"),
                    position: 'r',
                    align: 't',
                    width: 'auto',
                    height: 'auto',
                    content:"用户名不能为空"
                });
                flag = true;
            }
            if(password == ""){
                $.pt({
                    target: $("#forget-password"),
                    position: 'r',
                    align: 't',
                    width: 'auto',
                    height: 'auto',
                    content:"密码不能为空"
                });
                flag = true;
            }
            //用户名只能是15位以下的字母或数字
            var regExp = new RegExp("^[a-zA-Z0-9_]{1,15}$");
            if(!regExp.test(username)){
                $.pt({
                    target: $("#forget-username"),
                    position: 'r',
                    align: 't',
                    width: 'auto',
                    height: 'auto',
                    content:"用户名必须为15位以下的字母或数字"
                });
                flag = true;
            }
            //检查用户名是否存在
            //调后台方法

            //检查注册码是否正确
            if(code != '11111111'){
                $.pt({
                    target: $("#forget-code"),
                    position: 'r',
                    align: 't',
                    width: 'auto',
                    height: 'auto',
                    content:"注册码不正确"
                });
                flag = true;
            }



            if(flag){
                return false;
            }else{//重置密码
                spop({
                    template: '<h4 class="spop-title">重置密码成功</h4>即将于3秒后返回登录',
                    position: 'top-center',
                    style: 'success',
                    autoclose: 3000,
                    onOpen : function(){
                        var second = 2;
                        var showPop = setInterval(function(){
                            if(second == 0){
                                clearInterval(showPop);
                            }
                            $('.spop-body').html('<h4 class="spop-title">重置密码成功</h4>即将于'+second+'秒后返回登录');
                            second--;
                        },1000);
                    },
                    onClose : function(){
                        goto_login();
                    }
                });
                return false;
            }
        }
    </script>
    <style type="text/css">
        html{width: 100%; height: 100%;}

        body{

            background-repeat: no-repeat;

            background-position: center center #2D0F0F;

            background-color: #00BDDC;

            background-image: url(<?php echo \yii\helpers\Url::to("@web/img/snow.jpg", true)?>);

            background-size: 100% 100%;

        }

        .snow-container { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 100001; }

    </style>
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
            '<li><a id="wbcontact">关于</a></li>',
//            ['label' => '关于', 'url' => 'https://github.com/WalkingSun/WindBlog/blob/master/README.md'],
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


        <?= $content ?>

    <script>
        $("#wbcontact").click(function(){
            window.open('https://github.com/WalkingSun/WindBlog/blob/master/README.md');
        })

        $(".navbar-brand").click(function(){
            window.open('https://walkingsun.github.io/WindBlog/');
        })
    </script>
