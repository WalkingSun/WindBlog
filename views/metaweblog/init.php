<?php
/**
 * Created by PhpStorm.
 * User: walkingSun
 * Date: 2018/8/19
 * Time: 21:03
 */
$blogConfig = \yii\helpers\ArrayHelper::index($blogConfig,'blogType');
?>
<style>
    .checkboxs{
        margin: 20px 15px 0px 0px;
    }
</style>
<body ng-app="App" ng-controller="mainController" class="ng-scope">
<div class="cat_add">
    <div class="cat_add_header">
        <div class="icon"></div>
        <div class="title">博客配置</div>
    </div>
    <div class="cat_add_form">
        <label class="">博客园</label>
        <form  class="form-horizontal ng-pristine ng-valid" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="blogType" value="6">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">用户名</label>
                <div class="col-md-3">
                    <input class="form-control input-lg" type="text" name="username" value="<?=!empty($blogConfig[6]['username'])?$blogConfig[6]['username']:''?>" placeholder="请输入用户名">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">密码</label>
                <div class="col-md-3">
                    <input class="form-control input-lg" type="password" name="password" value="<?=!empty($blogConfig[6]['password'])?$blogConfig[6]['password']:''?>" placeholder="请输入密码">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">博客地址Id</label>
                <div class="col-md-3">
                    <input class="form-control input-lg" type="text" name="blogid" value="<?=!empty($blogConfig[6]['blogid'])?$blogConfig[6]['blogid']:''?>" placeholder="请输入地址id">
                </div>
                <span class="glyphicon glyphicon-asterisk star"></span>
                <label class="explain">如 https://www.cnblogs.com/followyou/，地址Id为followyou</label>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">开启TOC</label>
                <div class="col-md-3">
                    <input class="" type="radio" name="isTOC" value="1" <?=!empty($blogConfig[6]['isTOC'])?'checked':''?> >是</input>
                    <input class="" type="radio" name="isTOC" value="0"  <?=empty($blogConfig[6]['isTOC'])?'checked':''?>>否</input>
                </div>
                <!--                <span class="glyphicon glyphicon-asterisk star"></span>-->
                <!--                <label class="explain">启用</label>-->
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">启用</label>
                <div class="col-md-3">
                    <input class="" type="radio" name="isEnable" value="1" <?=!empty($blogConfig[6]['isEnable'])?'checked':''?> >是</input>
                    <input class="" type="radio" name="isEnable" value="0"  <?=empty($blogConfig[6]['isEnable'])?'checked':''?>>否</input>
                </div>
<!--                <span class="glyphicon glyphicon-asterisk star"></span>-->
<!--                <label class="explain">启用</label>-->
            </div>

            <div class="form-group form-group-sm" style="margin-top: 30px;">
                <div class="col-md-3 col-md-offset-2">
                    <div class="btn-group">
                        <button type="submit" onclick1111111="submit()" class="btn btn-danger btn-sm" title="设置"><i class="glyphicon glyphicon-floppy-save"></i> 设置</button>
                    </div>
                </div>
            </div>
        </form>


    </div>

    <div class="cat_add_form">
        <label class="">开源中国</label>
        <form  class="form-horizontal ng-pristine ng-valid" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="blogType" value="5">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">用户名</label>
                <div class="col-md-3">
                    <input class="form-control input-lg" type="text" name="username" value="<?=!empty($blogConfig[5]['username'])?$blogConfig[5]['username']:''?>" placeholder="请输入用户名">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">密码</label>
                <div class="col-md-3">
                    <input class="form-control input-lg" type="password" name="password" value="<?=!empty($blogConfig[5]['password'])?$blogConfig[5]['password']:''?>" placeholder="请输入密码">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">博客地址Id</label>
                <div class="col-md-3">
                    <input class="form-control input-lg"  type="text" name="blogid" value="<?=!empty($blogConfig[5]['blogid'])?$blogConfig[5]['blogid']:''?>" placeholder="请输入地址id">
                </div>
                <span class="glyphicon glyphicon-asterisk star"></span>
                <label class="explain">如 https://my.oschina.net/u/3293841/blog/1933344，地址Id为3293841</label>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">开启TOC</label>
                <div class="col-md-3">
                    <input class="" type="radio" name="isTOC" value="1" <?=!empty($blogConfig[5]['isTOC'])?'checked':''?> >是</input>
                    <input class="" type="radio" name="isTOC" value="0"  <?=empty($blogConfig[5]['isTOC'])?'checked':''?>>否</input>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">启用</label>
                <div class="col-md-3">
                    <input class="" type="radio" name="isEnable" value="1" <?=!empty($blogConfig[5]['isEnable'])?'checked':''?> >是</input>
                    <input class="" type="radio" name="isEnable" value="0"  <?=empty($blogConfig[5]['isEnable'])?'checked':''?>>否</input>
                </div>
                <!--                <span class="glyphicon glyphicon-asterisk star"></span>-->
                <!--                <label class="explain">启用</label>-->
            </div>

            <div class="form-group form-group-sm" style="margin-top: 30px;">
                <div class="col-md-3 col-md-offset-2">
                    <div class="btn-group">
                        <button type="submit" onclick1111111="submit()" class="btn btn-danger btn-sm" title="设置"><i class="glyphicon glyphicon-floppy-save"></i> 设置</button>
                    </div>
                </div>
            </div>
        </form>


    </div>

    <div class="cat_add_form">
        <label class="">CSDN</label>
        <form  class="form-horizontal ng-pristine ng-valid" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="blogType" value="3">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">用户名</label>
                <div class="col-md-3">
                    <input class="form-control input-lg" type="text" name="username" value="<?=!empty($blogConfig[3]['username'])?$blogConfig[3]['username']:''?>" placeholder="请输入用户名">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">密码</label>
                <div class="col-md-3">
                    <input class="form-control input-lg" type="password" name="password" value="<?=!empty($blogConfig[3]['password'])?$blogConfig[3]['password']:''?>" placeholder="请输入密码">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">博客地址Id</label>
                <div class="col-md-3">
                    <input class="form-control input-lg"  type="text" name="blogid" value="<?=!empty($blogConfig[3]['blogid'])?$blogConfig[3]['blogid']:''?>" placeholder="请输入地址id">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">开启TOC</label>
                <div class="col-md-3">
                    <input class="" type="radio" name="isTOC" value="1" <?=!empty($blogConfig[3]['isTOC'])?'checked':''?> >是</input>
                    <input class="" type="radio" name="isTOC" value="0"  <?=empty($blogConfig[3]['isTOC'])?'checked':''?>>否</input>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">启用</label>
                <div class="col-md-3">
                    <input class="" type="radio" name="isEnable" value="1" <?=!empty($blogConfig[3]['isEnable'])?'checked':''?> >是</input>
                    <input class="" type="radio" name="isEnable" value="0"  <?=empty($blogConfig[3]['isEnable'])?'checked':''?>>否</input>
                </div>
                <!--                <span class="glyphicon glyphicon-asterisk star"></span>-->
                <!--                <label class="explain">启用</label>-->
            </div>
            <div class="form-group form-group-sm" style="margin-top: 30px;">
                <div class="col-md-3 col-md-offset-2">
                    <div class="btn-group">
                        <button type="submit" onclick1111111="submit()" class="btn btn-danger btn-sm" title="设置"><i class="glyphicon glyphicon-floppy-save"></i> 设置</button>
                    </div>
                </div>
            </div>
        </form>


    </div>

    <div class="cat_add_form">
        <label class="">51cto</label>
        <form  class="form-horizontal ng-pristine ng-valid" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="blogType" value="1">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">用户名</label>
                <div class="col-md-3">
                    <input class="form-control input-lg" type="text" name="username" value="<?=!empty($blogConfig[1]['username'])?$blogConfig[1]['username']:''?>" placeholder="请输入用户名">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">密码</label>
                <div class="col-md-3">
                    <input class="form-control input-lg" type="password" name="password" value="<?=!empty($blogConfig[1]['password'])?$blogConfig[1]['password']:''?>" placeholder="请输入密码">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">博客地址Id</label>
                <div class="col-md-3">
                    <input class="form-control input-lg" readonly type="text" name="blogid" value="<?=!empty($blogConfig[1]['blogid'])?$blogConfig[1]['blogid']:''?>" placeholder="">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">开启TOC</label>
                <div class="col-md-3">
                    <input class="" type="radio" name="isTOC" value="1" <?=!empty($blogConfig[1]['isTOC'])?'checked':''?> >是</input>
                    <input class="" type="radio" name="isTOC" value="0"  <?=empty($blogConfig[1]['isTOC'])?'checked':''?>>否</input>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">启用</label>
                <div class="col-md-3">
                    <input class="" type="radio" name="isEnable" value="1" <?=!empty($blogConfig[1]['isEnable'])?'checked':''?> >是</input>
                    <input class="" type="radio" name="isEnable" value="0"  <?=empty($blogConfig[1]['isEnable'])?'checked':''?>>否</input>
                </div>
                <!--                <span class="glyphicon glyphicon-asterisk star"></span>-->
                <!--                <label class="explain">启用</label>-->
            </div>

            <div class="form-group form-group-sm" style="margin-top: 30px;">
                <div class="col-md-3 col-md-offset-2">
                    <div class="btn-group">
                        <button type="submit" onclick1111111="submit()" class="btn btn-danger btn-sm" title="设置"><i class="glyphicon glyphicon-floppy-save"></i> 设置</button>
                    </div>
                </div>
            </div>
        </form>


    </div>

</div>

<script>
    function submit(){
        var form = $("form").serialize();
        var url = '<?php echo \yii\helpers\Url::to(['metaweblog/add'])?>';
        $.post(url,form,function (r) {
            if(r.code==200){
                if( confirm("是否继续添加？") ){
                    location.href='<?php echo \yii\helpers\Url::to(['metaweblog/add'])?>';
                }else{
                    location.href='<?php echo \yii\helpers\Url::to(['metaweblog/index'])?>';
                }
                // layer.msg('success');
            }  else{
                layer.msg(r.msg);
            }
        },'json');
    }
</script>


</body>
