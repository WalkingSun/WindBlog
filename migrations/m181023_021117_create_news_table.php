<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m181023_021117_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="菜单表"';
        }

        $this->createTable('AM_user', [
            'userid' => $this->primaryKey(),
            'mobile' => $this->integer(11)->notNull(),
            'password' => $this->string(64)->notNull(),
            'userIn_userPasswd' => $this->string(255)->notNull(),
            'imei' => $this->string(255)->defaultValue(''),
            'token' => $this->string(255)->defaultValue(''),
            'imsi' => $this->string(255)->defaultValue(''),
            'remark' => $this->string(255)->defaultValue(''),
            'isDelete' => $this->smallInteger(2)->defaultValue(0),
            'loginClass' => $this->smallInteger(1)->notNull(),
            'clientVersion' => $this->string(255)->defaultValue('5.1.4'),
        ],$tableOptions);

        $this->createTable('AM_failQueue', [
            'queue_id' => $this->primaryKey(),
            'mobile' => $this->integer(11)->notNull(),
            'userIn_userPasswd' => $this->string(255)->notNull(),
            'imei' => $this->string(255)->defaultValue(''),
            'token' => $this->string(255)->defaultValue(''),
            'imsi' => $this->string(255)->defaultValue(''),
            'remark' => $this->string(255)->defaultValue(''),
            'isDelete' => $this->smallInteger(2)->defaultValue(0),
            'count' => $this->smallInteger(4)->defaultValue(0),
            'createtime' => $this->date(),
        ],$tableOptions);

        //博客分类关联表
        $this->createTable('JP_blogCategories',[
            'blogId'  => $this->integer()->notNull()->comment('博客记录id'),
            'blogType'  => $this->smallInteger()->notNull()->comment('博客类型 1代表51cto;2 sina;3 csdn;4 163;5 oschina;6 cnblogs;7 chinaunix'),
            'cates'  => $this->string(64)->notNull()->comment('博客分类 以逗号分隔'),
        ],$tableOptions);

        //博客记录表
        $this->createTable('JP_blogRecord',[
            'id'  => $this->primaryKey()->comment('博客记录id'),
            'title'  => $this->string()->comment('标题'),
            'content'  => $this->string(8000)->defaultValue('')->comment('博客内容'),
            'fileurl'  => $this->string(500)->defaultValue('')->comment('内容获取地址'),
            'cnblogsId'  => $this->string(32)->defaultValue('')->comment('cnblog博客id'),
            '51ctoId'  => $this->string(32)->defaultValue('')->comment('51cto博客id'),
            'sinaId'  => $this->string(32)->defaultValue('')->comment('sina博客id'),
            'csdnId'  => $this->string(32)->defaultValue('')->comment('csdn博客id'),
            '163Id'  => $this->string(32)->defaultValue('')->comment('163博客id'),
            'oschinaId'  => $this->string(32)->defaultValue('')->comment('oschina博客id'),
            'chinaunixId'  => $this->string(32)->defaultValue('')->comment('chinaunix博客id'),
            'cnblogsType'  => $this->string(32)->defaultValue('')->comment('博客类型'),
            'createtime'  => $this->date()->comment('创建时间'),
            'isDelete'  => $this->smallInteger()->comment('是否删除'),
            '51ctoType'  => $this->string(64)->comment('51cto博客分类，逗号分隔'),
            'sinaType'  => $this->string(64)->comment('sina博客分类，逗号分隔'),
            'csdnType'  => $this->string(64)->comment('csdn博客分类，逗号分隔'),
            '163Type'  => $this->string(64)->comment('163博客分类'),
            'oschinaType'  => $this->string(64)->comment('oschina博客分类'),
            'chinaunixType'  => $this->string(64)->comment('chinaunix博客分类'),
        ],$tableOptions);

        //博客用户信息配置表
        $this->createTable('JP_blogConfig',[
            'blogType'  => $this->smallInteger()->comment('博客类型 1代表51cto;2 sina;3 csdn;4 163;5 oschina;6 cnblogs;7 chinaunix'),
            'username'  => $this->string()->comment('用户名'),
            'password'  => $this->string(64)->comment('密码'),
            'blogid'  => $this->string()->comment('博客标识Id'),
            'isEnable'  => $this->smallInteger()->comment('启用'),
        ],$tableOptions);

        //博文队列
        $this->createTable('JP_blogQueue',[
            'queueId'  => $this->primaryKey()->comment('队列id'),
            'blogId'  => $this->integer(11)->comment('博客id'),
            'action'  => $this->smallInteger()->comment('执行动作，1 创建，2 更新，3 删除'),
            'publishStatus'  => $this->smallInteger()->comment('发布状态 0 待发布，1 发布中，2 发布完成，3 发布失败'),
            'response'  => $this->string()->comment('响应'),
            'createtime'  => $this->date()->comment('创建时间'),
            'updatetime'  => $this->date()->comment('更新时间'),
            'blogType'  => $this->smallInteger()->comment('博客类型 1代表51cto;2 sina;3 csdn;4 163;5 oschina;6 cnblogs;7 chinaunix'),
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('AM_user');
        $this->dropTable('AM_failQueue');

        $this->dropTable('JP_blogCategories');
        $this->dropTable('JP_blogRecord');
        $this->dropTable('JP_blogQueue');
        $this->dropTable('JP_blogConfig');
    }
}
