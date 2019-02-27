<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
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


<h4>知识复盘</h4>
</br>
<!--todo  知识复盘背景 -->


<div class="site-index">

    <div style="padding-bottom: 10px">

        <a href="<?=\yii\helpers\Url::to(['recovery/add'])?>"> 添加 </a>

        <a style="margin-right: 15px;" href="<?=\yii\helpers\Url::to(['recovery/config'])?>"> 启动复盘 </a>

    </div>

    <table >
        <thead style=" border-bottom-style: solid;">
        <tr>
            <th  scope="col">Id</th>
            <th scope="col" style="">标题</th>
            <th  scope="col">内容</th>
            <th  scope="col">连接</th>
<!--            <th scope="col">频率</th>-->
            <th scope="col">标签</th>
            <th scope="col">分类</th>
            <th scope="col">备注</th>
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
            <td ><?=$v['content']?:'--';?></td>
            <td ><a href="<?=$v['href']?>"><?=$v['href']?:'--';?></a></td>
<!--            <td >--><?//=$v['frequency']?:'--';?><!--</td>-->
            <td ><?=$v['tag']?:'--';?></td>
            <td ><?=$v['type']?:'--';?></td>
            <td ><?=$v['remark']?:'--';?></td>
            <td ><?=$v['createtime']?:'--';?></td>
            <td >
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
            'maxButtonCount' => 10,
        ]);
        ?>

    </div>

</div>
<script>
    function action(blogId, type ){
        if( type==3 ){
            var url = '<?php echo \yii\helpers\Url::to(['recovery/del'])?>';
            $.post(url,{id:blogId},function (r) {
                if(r.code==200){
                    // layer.msg(r.msg);
                    location.href='<?php echo \yii\helpers\Url::to(['recovery/index'])?>';
                }  else{
                    layer.msg(r.msg);
                }
            },'json');
            return false;
        }
        if( type==4 ){
            var url = '<?php echo \yii\helpers\Url::to(['recovery/edit','a'=>1])?>'+'&id='+blogId;
            location.href = url;
            return false;
        }
    }

</script>