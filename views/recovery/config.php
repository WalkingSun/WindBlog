<?php

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
        <div class="title">配置项</div>
    </div>
    <div class="cat_add_form">
        <form class="form-horizontal ng-pristine ng-valid" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="edit" value="1">
            <input type="hidden" name="id" value="<?=!empty($data['id'])?$data['id']:'';?>">
<!--            <div class="form-group form-group-sm">-->
<!--                <label class="control-label col-md-1">频率</label>-->
<!--                <div class="col-md-4">-->
<!--                    <input class="form-control input-lg" type="text" name="frequency" value="--><?//=!empty($data['frequency'])?$data['frequency']:'';?><!--" placeholder="请输入标题">-->
<!--                </div>-->
<!--                <span class="glyphicon glyphicon-asterisk star"></span>-->
<!--                <label class="explain">请输入频率</label>-->
<!--            </div>-->
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">发件邮箱</label>
                <div class="col-md-4">
                    <input class="form-control input-lg" name="setEmail" value="<?=!empty($data['setEmail'])?$data['setEmail']:'';?>" rows="10" placeholder="内容">
                </div>
                <label class="explain">请输入发件邮箱帐号</label>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">发件邮箱密码</label>
                <div class="col-md-4">
                    <input class="form-control input-lg" type="password" name="setEmailPwd" value="<?=!empty($data['setEmailPwd'])?$data['setEmailPwd']:'';?>" placeholder="请输入地址">
                </div>
                <span class="glyphicon glyphicon-asterisk star"></span>
                <label class="explain">请输入发件邮箱密码</label>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">POP3</label>
                <div class="col-md-4">
                    <input class="form-control input-lg" type="text" name="setPop3" value="<?=!empty($data['setPop3'])?$data['setPop3']:'';?>" placeholder="请输入setPop3">
                </div>
                <span class="glyphicon glyphicon-asterisk star"></span>
                <label class="explain">请输入POP3</label>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">SMTP</label>
                <div class="col-md-4">
                    <input class="form-control input-lg" type="text" name="setSmtp" value="<?=!empty($data['setSmtp'])?$data['setSmtp']:'';?>" placeholder="请输入地址SMTP">
                </div>
                <span class="glyphicon glyphicon-asterisk star"></span>
                <label class="explain">请输入地址SMTP</label>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">收件邮箱</label>
                <div class="col-md-4">
                    <input class="form-control input-lg" type="text" name="sendEmail" value="<?=!empty($data['sendEmail'])?$data['sendEmail']:'';?>" placeholder="请输入标签">
                </div>
                <span class="glyphicon glyphicon-asterisk star"></span>
                <label class="explain">请输入收件邮箱</label>
            </div>

             <div class="field-record-is_valid">
                <label class="control-label col-md-1">分类</label>
                <div class="checkbox">
                    <?php
                    if($tags){
                        $setTags = $data['typeList']?explode(',',$data['typeList']):[];
                        $typeList = \yii\helpers\ArrayHelper::index($tags,'type');
                        foreach ($typeList as $v){
                            $checked = in_array($v['type'],$setTags) ? 'checked="checked"':'';
                            echo '<label class="checkboxs"><input type="checkbox"  '.$checked.' value="'.$v['type'].'" name="typeList[]" > '.$v['type'].' </label>';
                        }
                    }
            ?>
<!--                <p class="help-block help-block-error"></p>-->
                </div>
            </div>

            <div class="field-record-is_valid">
                <label class="control-label col-md-1">标签</label>
                <div class="checkbox">
                    <?php
                    if($tags){
                        $setTags = $data['tagList']?explode(',',$data['tagList']):[];
                        $tagList = \yii\helpers\ArrayHelper::index($tags,'tag');
                        foreach ($tagList as $v){
                            if( !$v['tag'] ) continue;
                            $checked = in_array($v['tag'],$setTags) ? 'checked="checked"':'';
                            echo '<label class="checkboxs"><input type="checkbox"  '.$checked.' value="'.$v['tag'].'" name="tagList[]" > '.$v['tag'].' </label>';
                        }
                    }
                    ?>
<!--                    <p class="help-block help-block-error"></p>-->
                </div>
            </div>

        </br>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">启用</label>
                <div class="col-md-3">
                    <input class="" type="radio" name="isEnable" value="1" <?=!empty($data['isEnable'])?'checked':''?> >是</input>
                    <input class="" type="radio" name="isEnable" value="0"  <?=empty($data['isEnable'])?'checked':''?>>否</input>
                </div>
                <!--                <span class="glyphicon glyphicon-asterisk star"></span>-->
                <!--                <label class="explain">启用</label>-->
            </div>

        </form>

        <div class="form-group form-group-sm" style="margin-top: 30px;">
            <div class="col-md-3 col-md-offset-2">
                <div class="btn-group">
                    <button style="margin-right: 15px;" type="button" class="btn btn-default btn-sm" onclick="history.back()" title="返回"><i class="glyphicon glyphicon-chevron-left"></i> 返回</button>
                    <button type="submit" onclick="submit()" class="btn btn-danger btn-sm" title="提交"><i class="glyphicon glyphicon-floppy-save"></i> 提交</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function submit(){
            var form = $("form").serialize();
            var url = '<?php echo \yii\helpers\Url::to(['recovery/config'])?>';
            $.post(url,form,function (r) {
                if(r.code==200){
                    if( confirm("保存成功，是否继续编辑？") ){
                        location.href='<?php echo \yii\helpers\Url::to(['recovery/config'])?>';
                    }else{
                        location.href='<?php echo \yii\helpers\Url::to(['recovery/index'])?>';
                    }
                }  else{
                    layer.msg(r.msg);
                }
            },'json');
        }
    </script>


</body>