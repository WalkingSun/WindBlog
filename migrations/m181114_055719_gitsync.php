<?php

use yii\db\Migration;

class m181114_055719_gitsync extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="菜单表"';
        }

        //添加WindBlog git博客同步记录表
        $this->createTable('JP_gitWindblogSync', [
            'id' => $this->primaryKey(),
            'git_filename' => $this->string(64)->notNull()->comment('github上的文件名称'),
            'blog_title' => $this->string(64)->notNull()->comment('博客标题'),
            'blogRecord_id' => $this->integer(11)->comment('关联博客记录id'),
//            'blog_url' => $this->string(64)->notNull()->comment('博客地址'),
//            'cnblogs_class' => $this->string(64)->notNull()->comment('cnblogs博客分类'),
//            '51cto_class'  => $this->string(32)->defaultValue('')->comment('51cto博客分类'),
//            'sina_class'  => $this->string(32)->defaultValue('')->comment('sina博客分类'),
//            'csdn_class'  => $this->string(32)->defaultValue('')->comment('csdn博客分类'),
//            '163_class'  => $this->string(32)->defaultValue('')->comment('163博客分类'),
//            'oschina_class'  => $this->string(32)->defaultValue('')->comment('oschina博客分类'),
//            'chinaunix_class'  => $this->string(32)->defaultValue('')->comment('chinaunix博客分类'),
            'is_deal' => $this->smallInteger(1)->defaultValue(0)->comment('是否处理 1 是；0 否'),
            'createtime' =>$this->date()->comment('创建时间'),
            'remark' => $this->string(255)->defaultValue(''),
            'isDelete' => $this->smallInteger(2)->defaultValue(0),
        ],$tableOptions);

        //博客队列表增加JP_gitWindblogSync id关联
//        $this->addColumn('JP_blogQueue','gitId',$this->string(255)->defaultValue('')->comment('JP_gitWindblogSync id关联'));
    }

    public function safeDown()
    {
        $this->dropTable('JP_gitWindblogSync');
//        $this->dropColumn('JP_blogQueue','gitId');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181114_055719_gitsync cannot be reverted.\n";

        return false;
    }
    */
}
