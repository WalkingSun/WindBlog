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
        <div class="title">博客编辑</div>
    </div>
    <div class="cat_add_form">
        <form class="form-horizontal ng-pristine ng-valid" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="edit" value="1">
            <input type="hidden" name="blogId" value="<?php echo $record['id'];?>">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">博客标题</label>
                <div class="col-md-3">
                    <input class="form-control input-lg" type="text" name="title" value="<?php echo $record['title'];?>" placeholder="请输入标题">
                </div>
                <span class="glyphicon glyphicon-asterisk star"></span>
                <label class="explain">请输入8个字的以内的中文字符</label>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">博客内容</label>
                <div class="col-md-3">
                    <textarea class="form-control input-lg" name="content" value="<?php echo $record['content'];?>" rows="10" placeholder="请输入博客内容"><?php echo $record['content'];?></textarea>
                </div>
<!--                <span class="glyphicon glyphicon-asterisk star"></span>-->
                <label class="explain"></label>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">markdown地址</label>
                <div class="col-md-4">
                    <input class="form-control input-lg" type="text" name="fileurl" value="<?php echo $record['fileurl'];?>" placeholder="请输入markdown地址">
                </div>
                <span class="glyphicon glyphicon-asterisk star"></span>
                <label class="explain">请输入url地址</label>
            </div>

            <div class="field-record-is_valid">
                <label class="control-label col-md-1">cnblogs分类</label>
                <div class="checkbox">

                        <?php
                        $blogCategories = !empty($record['cnblogsType']) ? explode(',',$record['cnblogsType']) : ['[Markdown]'];
                        foreach ($Categories as $v){
                            if( strpos($v['title'],'网站分类')!==false ) continue;
                            $checked = in_array($v['title'],$blogCategories) ? 'checked="checked"':'';
                            echo '<label class="checkboxs"><input type="checkbox" '.$checked.' value="'.$v['title'].'" name="cnblogsType[]" > '.$v['title'].' </label>';
                        }
                        ?>

                    <p class="help-block help-block-error"></p>

                </div>
            </div>

        </form>

        <div class="form-group form-group-sm" style="margin-top: 30px;">
            <div class="col-md-3 col-md-offset-2">
                <div class="btn-group">
                    <button style="margin-right: 15px;" type="button" class="btn btn-default btn-sm" onclick="history.back()" title="返回"><i class="glyphicon glyphicon-chevron-left"></i> 返回</button>
                    <button type="submit" onclick="submit()" class="btn btn-danger btn-sm" title="提交"><i class="glyphicon glyphicon-floppy-save"></i> 添加</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function submit(){
        var form = $("form").serialize();
        var url = '<?php echo \yii\helpers\Url::to(['metaweblog/edit'])?>';
        $.post(url,form,function (r) {
            if(r.code==200){
                layer.msg('提交成功');
                location.href='<?php echo \yii\helpers\Url::to(['metaweblog/index'])?>';
            }  else{
                layer.msg(r.msg);
            }
        },'json');
    }
</script>


</body>