<?php

?>
<style type="text/css">

    /*table*/
    /*{*/
        /*table-layout: fixed;*/
        /*word-wrap: break-word;*/
        /*width: 100% !important;*/
    /*}*/

    /*table td,table th{*/
        /*text-align: center;*/
    /*}*/
    /* Border styles */
    table thead, #table tr {
        border-top-width: 1px;
        border-top-style: solid;
        border-top-color: rgb(230, 189, 189);
    }
    table {
        border-bottom-width: 1px;
        border-bottom-style: solid;
        border-bottom-color: rgb(230, 189, 189);
        width:100%;
        text-align: center;
    }

    /* Padding and font style */
    table td, #table th {
        padding: 11px 10px;
        font-size: 12px;
        font-family: Verdana;
        color: rgb(177, 106, 104);
    }

    /* Alternating background colors */
    table tr:nth-child(even) {
        background: rgb(238, 211, 210)
    }
    table tr:nth-child(odd) {
        background: #FFF
    }
</style>

<div class="site-index">

    <table >
        <thead>
        <tr>
            <th  scope="col">队列</th>
            <th  scope="col">博客网站</th>
            <th scope="col" style="">发布状态</th>
            <th  scope="col">response内容</th>
            <th scope="col" >创建时间</th>
            <th  scope="col">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if( $result ){
            foreach ($result as $v){
                $blogName = \app\models\Common::blogParamName($v['blogType']);
                ?>
                <tr>
                    <td ><?=$v['queueId'];?></td>
                    <td ><?=$blogName;?></td>
                    <td ><?=$v['publishStatus']==0? '未发布':($v['publishStatus']==1?'发布中':($v['publishStatus']==2?'发布完成':'发布失败') );?></td>
                    <td ><?=$v['response']?:'--';?></td>
                    <td ><?=$v['createtime'];?></td>
                    <td >
                        <?php if( in_array($v['publishStatus'],[0,1,3]) ){ ?>
                            <a href="javascript:parent.Sync('<?=$v['queueId'];?>')"> 点击发布</a>
<!--                            <a href="javascript:parent.UpdateQueue('--><?//=$v['queueId'];?><!--')"> 点击重试</a>-->
                        <?php }else{
                            echo '--';
                        }?>
                    </td>
                </tr>
            <?php    }
        }
        ?>

        </tbody>
    </table>



</div>
<script>


</script>


