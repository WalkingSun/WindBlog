<?php

$action = empty($data)?'add':'edit';

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
        <div class="title">技术点添加</div>
    </div>
    <div class="cat_add_form">
        <form class="form-horizontal ng-pristine ng-valid" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="edit" value="1">
            <input type="hidden" name="id" value="<?=!empty($data['id'])?$data['id']:'';?>">
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">标题</label>
                <div class="col-md-4">
                    <input class="form-control input-lg" type="text" name="title" value="<?=!empty($data['title'])?$data['title']:'';?>" placeholder="请输入标题">
                </div>
                <span class="glyphicon glyphicon-asterisk star"></span>
                <label class="explain">请输入标题</label>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">内容</label>
                <div class="col-md-3">
                    <textarea class="form-control input-lg" name="content" value="<?=!empty($data['content'])?$data['content']:'';?>" rows="10" placeholder="内容"></textarea>
                </div>
                <label class="explain">请输入内容</label>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">地址</label>
                <div class="col-md-4">
                    <input class="form-control input-lg" type="text" name="href" value="<?=!empty($data['href'])?$data['href']:'';?>" placeholder="请输入地址">
                </div>
                <span class="glyphicon glyphicon-asterisk star"></span>
                <label class="explain">请输入url地址</label>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">标签</label>
                <div class="col-md-4">
                    <input class="form-control input-lg" type="text" name="tag" value="<?=!empty($data['tag'])?$data['tag']:'';?>" placeholder="请输入标签">
                </div>
                <span class="glyphicon glyphicon-asterisk star"></span>
                <label class="explain">请输入标签</label>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-md-1">分类</label>
                <div class="col-md-4">
                    <input class="form-control input-lg" type="text" name="type" value="<?=!empty($data['type'])?$data['type']:'';?>" placeholder="请输入标签">
                </div>
                <span class="glyphicon glyphicon-asterisk star"></span>
                <label class="explain">请输入标签</label>
            </div>
            <div class="form-group form-group-sm">
                <!--    todo  先用文本代替  后期改用插件  -->
                <label class="control-label col-md-1">频率</label>
                <div class="col-md-4">
                    <input class="form-control input-lg" type="text" name="frequency" value="<?=!empty($data['frequency'])?$data['frequency']:'';?>" placeholder="请输入标签">
                </div>
                <span class="glyphicon glyphicon-asterisk star"></span>
                <label class="explain">格式参照 crontab</label>
            </div>


        </form>

        <div class="form-group form-group-sm" style="margin-top: 30px;">
            <div class="col-md-3 col-md-offset-2">
                <div class="btn-group">
                    <button style="margin-right: 15px;" type="button" class="btn btn-default btn-sm" onclick="history.back()" title="返回"><i class="glyphicon glyphicon-chevron-left"></i> 返回</button>
                    <button type="submit" onclick="submit()" class="btn btn-danger btn-sm" title="添加"><i class="glyphicon glyphicon-floppy-save"></i> 添加</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function submit(){
            var form = $("form").serialize();
            var url = '<?php echo \yii\helpers\Url::to(['recovery/'.$action])?>';
            $.post(url,form,function (r) {
                if(r.code==200){
                    if( confirm("是否继续添加？") ){
                        location.href='<?php echo \yii\helpers\Url::to(['recovery/'.$action])?>';
                    }else{
                        location.href='<?php echo \yii\helpers\Url::to(['recovery/index'])?>';
                    }
                    // layer.msg('success');
                }  else{
                    layer.msg(r.msg);
                }
            },'json');
        }
    </script>


</body>