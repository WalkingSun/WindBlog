<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2019/2/18
 * Time: 10:18
 */
use yii\helpers\Html;
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Home</title>
    <style>
        html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,dl,dt,dd,ol,nav ul,nav li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline;}
        article, aside, details, figcaption, figure,footer, header, hgroup, menu, nav, section {display: block;}
        ol,ul{list-style:none;margin:0;padding:0;}
        blockquote,q{quotes:none;}
        blockquote:before,blockquote:after,q:before,q:after{content:'';content:none;}
        table{border-collapse:collapse;border-spacing:0;}
        /* start editing from here */
        a{text-decoration:none;}
        .txt-rt{text-align:right;}/* text align right */
        .txt-lt{text-align:left;}/* text align left */
        .txt-center{text-align:center;}/* text align center */
        .float-rt{float:right;}/* float right */
        .float-lt{float:left;}/* float left */
        .clear{clear:both;}/* clear float */
        .pos-relative{position:relative;}/* Position Relative */
        .pos-absolute{position:absolute;}/* Position Absolute */
        .vertical-base{	vertical-align:baseline;}/* vertical align baseline */
        .vertical-top{	vertical-align:top;}/* vertical align top */
        .underline{	padding-bottom:5px;	border-bottom: 1px solid #eee; margin:0 0 20px 0;}/* Add 5px bottom padding and a underline */
        nav.vertical ul li{	display:block;}/* vertical menu */
        nav.horizontal ul li{	display: inline-block;}/* horizontal menu */
        img{max-width:100%;}
        /*end reset*/
        /*--login start here--*/
        body{
            font-size: 100%;
            background:#166ec4;
            font-family: 'Roboto Slab', serif;
        }
        a {
            text-decoration: none;
        }
        a:hover {
            transition: 0.5s all;
            -webkit-transition: 0.5s all;
            -moz-transition: 0.5s all;
            -o-transition: 0.5s all;
        }
        /*--header start here--*/
        .newsletter {
            background: url(../img/banner.jpg)no-repeat;
            background-size: cover;
            min-height:600px;
            width: 32%;
            margin: 4.5em auto 2em;
        }
        .newsletter-main {
            width: 90%;
            margin: 0 auto;
            padding: 0.5em 0em;
            text-align: center;
        }
        .stamp img {
            width: 13%;
        }
        .stamp {
            text-align: right;
        }
        .newsletter-main h1 {
            font-size:2em;
            color: #000;
            font-weight: 300;
        }
        .newsletter-main h2{
            font-size:2em;
            color: #000;
            margin: 0em 0em 0.5em 0em;
        }
        .newsletter-main p {
            font-size: 1.1em;
            color: #000;
            line-height: 1.5em;
            width:80%;
            margin: 0.5em auto 0.5em;
        }
        a.signup {
            font-size: 1.2em;
            color: #4882ce;
            font-weight: 600;
            display: block;
            margin: 0em 0em 1em 0em;
        }
        .newsletter-main input[type="text"] {
            font-size: 1em;
            color: #000;
            padding: 0.8em 1em;
            border: 3px solid #4882ce;
            border-radius: 5px;
            display: inline-block;
            width: 80%;
            outline:none;
            text-align: center;
            margin: 0em auto 1em;
            font-family: 'Roboto Slab', serif;
        }
        #check {
            font-size: 1.2em;
            color: #fff;
            padding: 0.7em 2.5em;
            outline: none;
            border: none;
            border-radius: 5px;
            background: #00ab00;
            display: inline-block;
            margin-bottom: 1.1em;
            cursor:pointer;
            font-family: 'Roboto Slab', serif;
        }
        #check:hover {
            background:#4882ce;
        }
        .tlg {
            margin: 1em 0em 1em 0em;
        }
        .tlg-img {
            float: left;
            width: 20%;
        }
        .tlg-text {
            float: right;
            width: 80%;
            text-align: left;
        }
        .tlg-text h3 {
            font-size:1.6em;
            color: #166EC4;
        }
        .tlg-text h4 {
            font-size: 1em;
            color: #000;
        }
        .tlg-img img {
            width:60%;
        }
        .clear{
            clear:both;
        }
        /*---copyrights--*/
        .copy-right {
            margin: 3em 0em 2em 0em;
        }
        .copy-right p {
            text-align: center;
            font-size: 1em;
            color: #fff;
            line-height: 1.5em;
            font-family: 'Quicksand', sans-serif;
        }
        .copy-right p a{
            color:#fff;
        }
        .copy-right p a:hover{
            color:#fff;
            text-decoration:underline;
            transition: 0.5s all;
            -webkit-transition: 0.5s all;
            -moz-transition: 0.5s all;
            -o-transition: 0.5s all;
        }
        /*--media quiries start here--*/
        @media(max-width:1440px){
            .newsletter-main p {
                width: 95%;
            }
            .newsletter {
                min-height: 580px;
            }
        }
        @media(max-width:1280px){
            .tlg-text h3 {
                font-size: 1.5em;
            }
            .tlg-text h4 {
                font-size: 1em;
            }
            .newsletter-main input[type="submit"] {
                margin-bottom: 1em;
            }
            .newsletter {
                width: 35%;
            }
        }
        @media(max-width:1024px){
            .newsletter {
                min-height: 600px;
                width: 45%;
            }
            .newsletter {
                min-height: 580px;
            }
        }
        @media(max-width:768px){
            .newsletter {
                width: 57%;
            }
        }
        @media(max-width:640px){
            .newsletter {
                width: 72%;
            }
        }
        @media(max-width:480px){
            .newsletter-main h1 {
                font-size: 1.5em;
            }
            .newsletter-main h2 {
                font-size: 1.5em;
            }
            .newsletter-main p {
                font-size:0.95em;
            }
            a.signup {
                font-size: 1.1em;
                margin: 0em 0em 0.7em 0em;
            }
            .newsletter-main input[type="text"] {
                font-size:0.85em;
                padding: 0.7em 1em;
            }
            .newsletter-main input[type="submit"] {
                font-size:0.9em;
                margin-bottom: 1.5em;
            }
            .tlg-img img {
                width: 75%;
            }
            .tlg-text h3 {
                font-size: 1.3em;
            }
            .tlg-text h4 {
                font-size:0.8em;
            }
            .newsletter {
                min-height: 475px;
            }
            .copy-right p {
                font-size: 0.9em;
            }
        }
        @media(max-width:384px){
            .newsletter {
                width: 80%;
            }
        }
        @media(max-width:320px){
            .newsletter-main h1 {
                font-size: 1.5em;
            }
            .newsletter-main h2 {
                font-size: 1.5em;
            }
            .newsletter-main p {
                font-size: 1em;
            }
            a.signup {
                font-size: 1.1em;
            }
            .newsletter-main input[type="text"] {
                font-size: 0.75em;
                padding: 0.7em 0.5em;
            }
            .newsletter-main input[type="submit"] {
                margin-bottom: 1em;
            }
            .design img {
                width: 70%;
            }
            .newsletter {
                width: 92%;
                min-height: 425px;
                margin: 1em auto;
            }
            .copy-right {
                margin: 1em 0em 1em 0em;
            }
            .copy-right p {
                font-size: 0.8em;
            }
        }
        /*--media quiries end here--*/
    </style>
    <!-- Custom Theme files -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Easy Subscribe Form Responsive, Login form web template, Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
    <!--google fonts-->
</head>
<body>
<div class="newsletter">
    <div class="newsletter-main">
        <div class="stamp">
            <img src="<?=Yii::$app->params['hostname'].'/img/stamp.png'?>" alt="">
        </div>
        <h1><?=$data['title']?></h1>
<!--        <h2>exclusive goodies!</h2>-->
        <div class="design">
            <img src="<?=Yii::$app->params['hostname'].'/img/design.png'?>">
        </div>
        <p><?=$data['content']?></p>
        <a href="#" class="signup">查看连接进入详情</a>
        <form>
            <input type="text" readonly value="<?=$data['href']?>">
            <a href="<?=$data['href']?>" id="check">查看</a>
        </form>
        <div class="design">
            <img src="<?=Yii::$app->params['hostname'].'/img/design.png'?>">
        </div>
    </div>
</div>
<div class="copy-right">
    <p>Copyright &copy; 2019.来源<a target="_blank" href="<?=Yii::$app->params['hostname']?>">WindBlog</a></p>
</div>
</body>
</html>
