<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2019/2/18
 * Time: 10:18
 */
use yii\helpers\Html;


?>
<html class=" MacOS">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    <meta name="referrer" content="origin">
    <meta name="renderer" content="webkit">
    <title><?= $data['title'] ?></title>
    <script>
        document.domain = "mail.qq.com";
        function getTop() {
            var f = arguments.callee, w;
            !(f.execption) && (f.execption = "");
            if (!f.t) {
                try {
                    w = window;
                    f.t = w != parent ? (parent.getTop ? parent.getTop() : parent.parent.getTop()) : w;
                } catch (e) {
                    f.t = reTryGetTop();
                    f.execption = e.message;
                }
            }
            return f.t;
        }
        function reTryGetTop() {
            var _oWin = window,
                _oWinParent = parent;
            try {
                while (_oWin != _oWinParent) {
                    _oWin = _oWinParent;
                    _oWinParent = _oWinParent.parent;
                }
            }
            catch (e) {
                ossLogForSetFrame.getTopException = true;
            }
            return _oWin;
        };
        try {
            window.top = getTop();
        } catch (e) {
            eval("var top=getTop();");
        }
        var gsUsed = "320";
        var gbSupportNW = true;
        var g_uin = "807493510";
        window == getTop() && document.write('<script src="https://rescdn.qqmail.com/zh_CN/htmledition/js/webp/all47d640.js"></' + 'script>');
        (getTop().initPageEvent || function () {
        })(window);
    </script>
    <script>parent.beginStatTime && parent.beginStatTime(window);</script>
    <script>
        (function () {
            getTop().rdVer.check(window, "ZC1206-TMozks0SjK3lfEwRH0eyI98", 27016);
        })();
    </script>
    <link rel="stylesheet" type="text/css"
          href="https://rescdn.qqmail.com/zh_CN/htmledition/style/webp/comm2010469107.css">
    <link rel="stylesheet" type="text/css"
          href="https://rl.mail.qq.com/cgi-bin/getcss?sid=zUsx9qkTFjdjCjpn&amp;ft=skin">
    <link rel="stylesheet" type="text/css"
          href="https://rescdn.qqmail.com/zh_CN/htmledition/style/webp/readmail201242eb45.css">
    <script>
        getTop().loadJsFileToTop([
            "https://rescdn.qqmail.com/zh_CN/htmledition/js/webp/readmail245b44b.js",
            "https://rescdn.qqmail.com/zh_CN/htmledition/js/webp/qmqzoneimg24e6b9.js",
            "https://rescdn.qqmail.com/zh_CN/htmledition/js/webp/com/kits/qmeditor/qqmail/release/editor47d62d.js",
            "https://rescdn.qqmail.com/zh_CN/htmledition/js/webp/com/kits/qmpreviewer/js/qmpreviewer392e89.js", "https://rescdn.qqmail.com/zh_CN/htmledition/js/webp/location_identify/location_identify25f2fd.js"
        ]);

        getTop().loadJsFileToTop(["https://rescdn.qqmail.com/zh_CN/htmledition/js/webp/qmnetdisk38a714.js"]);
    </script>
    <script> /*function SendStatusOpt(isIng, isFail)
         {
         getTop().show(getTop().S("sendstatusloading", document), isIng);
         getTop().show(getTop().S("sendstatusloadfail", document), isFail);
         }

         function GetSendStatusIng()
         {
         SendStatusOpt(true, false);
         }

         function GetSendStatusOK()
         {
         SendStatusOpt(false, false);
         }

         function GetSendStatusFail()
         {
         var frame = getTop().S("mailSendStatus", document);
         if (getTop().isShow("sendstatusloading") && frame.src != "")
         {
         SendStatusOpt(false, true);
         frame.src = "";
         }
         }*/

        _sModule = "sendstatus";
        function StatusOpt(isIng, isFail) {
            getTop().show(getTop().S(_sModule + "loading", document), isIng);
            getTop().show(getTop().S(_sModule + "loadfail", document), isFail);
        }

        function GetStatusIng() {
            StatusOpt(true, false);
        }

        function GetStatusOK() {
            StatusOpt(false, false);
        }

        function GetStatusFail() {
            var frame = getTop().S("mail" + _sModule, document);
            if (getTop().isShow(_sModule + "loading") && frame.src != "") {
                StatusOpt(false, true);
                frame.src = "";
            }
        }


        function checkSenderImg(_aImgObj, _aReportEmail) {
            var _isLoadGravaterOK = parseInt(_aImgObj.width) == 40 || parseInt(_aImgObj.width) == 96;
            if (_isLoadGravaterOK) {
                _aImgObj.parentNode.style.visibility = 'visible';
            }
        }

    </script>
    <style>body {
            background: #fff;
            color: #000;
            font-weight: normal;
            font-family: "lucida Grande", Verdana, "Microsoft YaHei";
            padding: 0 7px 6px 4px;
            margin: 0;
        }

        .MacOS body {
            font-family: "lucida Grande", Verdana;
        }

        .qmbox {
            padding: 0;
        }

        .qm_con_body_content {
            height: auto;
            min-height: 100px;
            _height: 100px;
            word-wrap: break-word;
            font-size: 14px;
            font-family: "lucida Grande", Verdana, "Microsoft YaHei";
        }

        .MacOS .qm_con_body_content {
            font-family: "lucida Grande", Verdana;
        }

        body.thumb_list_readmail {
            padding: 0;
        }

        .thumb_list_readmail #nextnewDiv, .thumb_list_readmail #nextmail_top, .thumb_list_readmail #nextmail_bt {
            display: none;
        }</style>
</head>
<body context="ZC1206-TMozks0SjK3lfEwRH0eyI98" module="qmReadMail" md="md" mu="mu" class="">
<div class="mailcontainer" id="qqmail_mailcontainer">
    <div id="mainmail" style="position:relative;z-index:1;margin-bottom:12px;"><!-- page end-->
        <div id="contentDiv" onmouseover="getTop().stopPropagation(event);" onclick="getTop().preSwapLink(event, 'html', 'ZC1206-TMozks0SjK3lfEwRH0eyI98');"
             style="position:relative;font-size:14px;height:auto;padding:15px 15px 10px 15px;z-index:1;zoom:1;line-height:1.7;"
             class="body">
            <div id="qm_con_body">
                <div id="mailContentContainer" class="qmbox qm_con_body_content qqmail_webmail_only" style="">


                    <table class="edm__main" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f6f6f6;" bgcolor="#f6f6f6">
                        <tbody>
                        <tr style="border-collapse: collapse;">
                            <td align="center" bgcolor="#f6f6f6" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;">
                                <table class="w640" style="margin: 0 10px;" width="640" cellpadding="0" cellspacing="0" border="0">
                                    <tbody>
                                    <tr style="border-collapse: collapse;">
                                        <td class="w640" width="640" height="5"
                                            style="border-collapse: collapse; background-color: #009A61;"
                                            bgcolor="#009A61"></td>
                                    </tr>
                                    <tr style="border-collapse: collapse;">
                                        <td id="header" class="w640" width="640" align="center" bgcolor="#FFFFFF" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;">
                                            <div align="center" style="text-align: center;">
                                                <a href="http://47.99.189.105:81" rel="noopener" target="_blank">
<!--                                                    <img id="customHeaderImage" label="Header Image" editable="true" width="230" src="http://s.segmentfault.com/img/mail-weekly.png" class="w640" border="0" align="top" style="display: inline; outline: none; text-decoration: none; padding: 30px 0;"></a>-->
                                                    WindBlog . WalkingSun
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="banner" style="border-collapse: collapse;">
                                        <td>
                                            <a href="https://segmentfault.com/n/1330000019932639?utm_source=weekly&amp;utm_medium=email&amp;utm_campaign=email_weekly" rel="noopener" target="_blank"></a>
                                        </td>
                                    </tr>
                                    <tr id="simple-content-row" style="border-collapse: collapse;">
                                        <td class="w640" width="640" bgcolor="#ffffff" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;">
                                            <table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
                                                <tbody>
                                                <tr style="border-collapse: collapse;">
                                                    <td class="w30" width="30"
                                                        style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;"></td>
                                                    <td class="w580" width="580"
                                                        style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;">
                                                        <repeater>
                                                            <layout label="Text only">
                                                                <table class="w580" width="580" cellpadding="0"
                                                                       cellspacing="0" border="0">
                                                                    <tbody>
                                                                        <?php
                                                                        if( $data ){
                                                                            foreach ($data['news'] as $v){?>
                                                                        <tr style="border-collapse: collapse;">
                                                                        <td class="w580" width="580"
                                                                            style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;">
                                                                            <br><br>

                                                                            <p align="left" class="article-title"
                                                                               style="font-size: 14px; line-height: 1; color: #222222; font-weight: bold; margin-top: 0px; margin-bottom: 18px; font-family: Helvetica, Arial, sans-serif;">
                                                                                <singleline label="Title">  <?=$v['subtitle'];?> </singleline>
                                                                            </p>

                                                                            <div align="left" class="article-content" style="font-size: 13px; line-height: 20px; color: #444444; margin-top: 0px; margin-bottom: 18px; font-family: Helvetica, Arial, sans-serif;">
                                                                                <multiline label="Description">
                                                                                    <table>
                                                                                        <tbody>

                                                                            <?php
                                                                                foreach ($v['data'] as $vv) {?>
                                                                                    <tr style="border-collapse: collapse;">
                                                                                        <td class="q-item"
                                                                                            style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif; font-size: 12px; line-height: 20px; padding: 0 0 15px 0;">
                                                                                            <a href="<?=$vv['url'];?>"
                                                                                               class="q-title"
                                                                                               style="color: #009a61; font-weight: bold; text-decoration: none; font-size: 14px;"
                                                                                               rel="noopener"
                                                                                               target="_blank"><strong><?=$vv['title'];?></strong></a><br>
                                                                                            <p style="margin: 0;font-family: Source Code Pro,Consolas,Menlo,Monaco,Courier New,monospace;color: #666; ">
<!--                                                                                                <span>▶ LeanCloud</span><span style="color: #dddddd;">&nbsp; |&nbsp; </span>-->
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php }
                                                                            ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </multiline>
                                                                            </div>
                                                                            <div style="border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #EEE; margin-bottom: 5px;"></div>
                                                                        </td>
                                                                        </tr>

                                                                            <?php    }
                                                                        }?>
                                                                    </tbody>
                                                                </table>
                                                            </layout>
                                                        </repeater>
                                                    </td>
                                                    <td class="w30" width="30"
                                                        style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class="banner" width="640" style="border-collapse: collapse;">
                                        <td></td>
                                    </tr>
                                    <tr style="border-collapse: collapse;">
                                        <td class="w640" width="640"
                                            style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;">
                                            <table id="footer" class="w640" width="640" cellpadding="0" cellspacing="0"
                                                   border="0" bgcolor="#5E6E68"
                                                   style="-webkit-font-smoothing: antialiased; height: 95px;color: #C1D2CB; background-color: #5E6E68;">
                                                <tbody>
                                                <tr style="border-collapse: collapse;">
                                                    <td class="w30" width="30"
                                                        style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;"></td>
                                                    <td class="w580" width="580" valign="top"
                                                        style="border-collapse: collapse;font-family: Helvetica, Arial, sans-serif;">
                                                        <div style="font-size:13px;color:#ffffff;margin-bottom: 7px;margin-top:25px;">
                                                            <span>WindBlog —— 帮助你成长的平台</span></div>
                                                        <div id="permission-reminder" align="left" class="footer-content-left" style="-webkit-text-size-adjust: none; -ms-text-size-adjust: none; font-size: 12px; line-height: 15px; color: #C1D2CB; margin-top: 0px; margin-bottom: 25px; white-space: normal;">
                                                            <span>
                                                                <a href="http://47.99.189.105:81" style="color: #C1D2CB;text-decoration: none" rel="noopener" target="_blank">windblog</a>
                                &nbsp;
                                                                <span style="color: #C1D2CB;">|</span>
                                                                &nbsp;
                                                               <a href="http://47.99.189.105:81" style="color: #C1D2CB;text-decoration: none" rel="noopener" target="_blank">@windblog</a> &nbsp;
                                                                <span style="color: #C1D2CB;">|</span>&nbsp;

<!--                                                                <a href="http://segmentfault.com/user/settings?tab=notify" style="color: #C1D2CB;text-decoration: none" rel="noopener" target="_blank">退订邮件</a>-->
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="w30" width="30"
                                                        style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;">

                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr style="border-collapse: collapse;">
                                        <td class="w640" width="640" height="60"
                                            style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <style type="text/css">.qmbox style, .qmbox script, .qmbox head, .qmbox link, .qmbox meta {
                            display: none !important;
                        }</style>
                </div>
            </div><!-- -->
            <style>#mailContentContainer .txt {
                    height: auto;
                }</style>
        </div>
    </div>
</div>
</body>
</html>