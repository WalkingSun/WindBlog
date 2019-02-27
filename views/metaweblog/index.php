<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
$cnblogName = !empty($blogConfig['blogid'])?$blogConfig['blogid']:'';
?>
<style type="text/css">

    table
    {
        /*table-layout: fixed;*/
        /*word-wrap: break-word;*/
        /*width: 100% !important;*/
        border-bottom-width: 1px;
        border-bottom-style: solid;
        border-bottom-color: rgb(230, 189, 189);
        width:100%;
    }

    table td,table th{
        padding: 12px 10px;
        font-size: 12px;
        font-family: Verdana;
        color: rgb(95, 74, 121);
        text-align: center;
    }
    table thead, #table-4 tr {
        border-top-width: 1px;
        border-top-style: solid;
        border-top-color: rgb(211, 202, 221);
    }
    /* Alternating background colors */
    table tr:nth-child(even) {
        background: rgb(223, 216, 232)
    }
    table tr:nth-child(odd) {
        background: #FFF
    }

    .paginationDiv{
        /*width:200px;*/
        text-align: center;
        /*margin: 0 auto;*/
    }
</style>


<h4>博客自动化发布</h4>
</br>

<div class="site-index">

    <div style="padding-bottom: 10px">
        <a style="margin-right: 15px;" href="<?=\yii\helpers\Url::to(['metaweblog/init'])?>"> 自动化配置 </a>

        <a href="<?=\yii\helpers\Url::to(['metaweblog/add'])?>"> 添加 </a>

    </div>

    <table >
        <thead style=" border-bottom-style: solid;">
        <tr>
            <th  scope="col">Id</th>
            <th scope="col" style="">标题</th>
<!--            <th  scope="col">内容</th>-->
            <th  scope="col">mark文件</th>
<!--            <th scope="col">cnblogs博客</th>-->
            <?php
                if( $blogConfig ){
                    foreach ($blogConfig as $v){
                        $blogName = \app\models\Common::blogParamName($v['blogType']);
                        echo '<th scope="col">'.$blogName.'博客分类</th>';
                    }
                }
            ?>

<!--            <th scope="col">cnblogs博客分类</th>-->
            <th scope="col" >创建时间</th>
            <th  scope="col">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if( $result ){
            foreach ($result as $v){ ?>
        <tr>
            <td ><?=$v['id'];?></td>
            <td ><?=$v['title'];?></td>
<!--            <td >--><?//=$v['content']?:'--';?><!--</td>-->
            <td ><a href="<?=$v['fileurl'];?>"  target="view_window"><?=$v['fileurl']?'查看':'--'//="https://www.cnblogs.com/{$cnblogName}/p/{$v['cnblogsId']}.html";?></a></td>
<!--            <td ><a href="--><?//="https://www.cnblogs.com/{$cnblogName}/p/{$v['cnblogsId']}.html";?><!--"  target="view_window">--><?//=$v['cnblogsId']?'查看':'--'//="https://www.cnblogs.com/{$cnblogName}/p/{$v['cnblogsId']}.html";?><!--</a></td>-->
            <?php
            if( $blogConfig ){
                foreach ($blogConfig as $v1){
                    $blogName = \app\models\Common::blogParamName($v1['blogType']);
                    echo '<td >'.$v[$blogName.'Type'].'</td>';
                }
            }
            ?>

<!--            <td >--><?//=$v['cnblogsType'];?><!--</td>-->
            <td ><?=$v['createtime'];?></td>
            <td >
                <a href="javascript:checkQueue('<?=$v['id'];?>')"> 查看队列</a>
                <a style="cursor:pointer;" onclick="action('<?=$v['id'];?>','<?=$v['cnblogsId']?2:1;?>')" ><?=$v['cnblogsId']?'发送队列':'发送队列';?></a>
                <a style="cursor:pointer;" onclick="action('<?=$v['id'];?>',4)">修改</a>
                <a style="cursor:pointer;" onclick="action('<?=$v['id'];?>',3)">删除</a>
            </td>
        </tr>
        <?php    }
        }
        ?>

     </tbody>
    </table>
    <div class="paginationDiv">
        <?php
        echo \yii\widgets\LinkPager::widget([
            'pagination'=>$pagination,//分页类
//            'options'=>['class'=>'page'],  //设置分页组件样式
            'firstPageLabel' => '首页',
            'prevPageLabel' => '《',
            'nextPageLabel' => '》',
            'lastPageLabel' => '尾页',
            'maxButtonCount' => 10
        ]);
        ?>

    </div>

</div>
<script>
    function action(blogId, type ){
        if( type==3 ){
            var url = '<?php echo \yii\helpers\Url::to(['metaweblog/del'])?>';
            $.post(url,{blogId:blogId},function (r) {
                if(r.code==200){
                    // layer.msg(r.msg);
                    location.href='<?php echo \yii\helpers\Url::to(['metaweblog/index'])?>';
                }  else{
                    layer.msg(r.msg);
                }
            },'json');
            return false;
        }
        if( type==4 ){
            var url = '<?php echo \yii\helpers\Url::to(['metaweblog/edit','a'=>1])?>'+'&blogId='+blogId;
            location.href = url;
            return false;
        }
        var url = '<?php echo \yii\helpers\Url::to(['metaweblog/queue','a'=>1])?>&type='+type;
       $.post(url,{blogId:blogId,action:type},function (r) {
             if(r.code==200){
                 layer.msg(r.msg);
             }  else{
                 layer.msg(r.msg);
             }
       },'json');
    }

    function checkQueue( blogid ){
        //iframe层

        layer.open({
            type: 2,
            title: '队列记录',
            shadeClose: true,
            shade: 0.8,
            area: ['600px', '90%'],
            content: '<?=\yii\helpers\Url::to(['metaweblog/checkqueue','a'=>1])?>'+'&blogid='+blogid
        });
    }

    UpdateQueue = function updateQueue( queueid ){
        var url = '<?=\yii\helpers\Url::to(['metaweblog/updatequeue','a'=>1])?>&queueid='+queueid;
        $.post(url,{queueid:queueid},function (r) {
            if(r.code==200){
                layer.msg(r.msg);
                var index = parent.layer.getFrameIndex(window.name);
                setTimeout(function(){parent.layer.close(index)}, 1000);
            }  else{
                layer.msg(r.msg);
            }
        },'json');
    }

    Sync = function Sync( queueid ){
        var url = '<?=\yii\helpers\Url::to(['metaweblog/sync','a'=>1])?>&queueid='+queueid;
        var loading = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
        $.post(url,{queueid:queueid},function (r) {
            parent.layer.close(loading);
            if(r.code==200){
                layer.msg(r.msg);
                setTimeout(function(){parent.layer.closeAll();}, 2000);
            }  else{
                layer.msg(r.msg);
                // setTimeout(function(){parent.layer.closeAll();}, 1000);
            }

        },'json');
    }
</script>