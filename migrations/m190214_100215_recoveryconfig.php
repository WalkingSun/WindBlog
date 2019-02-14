<?php

use yii\db\Migration;

class m190214_100215_recoveryconfig extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="jump"';
        }

        //知识复盘配置
        $this->createTable('JP_knowledgeRecoveryConfig',[
            'userId' => $this->string(8000),
            'frequency' => $this->string(32)->notNull()->comment('频率 参照crontab格式'),
            'typeList'  => $this->string(255)->defaultValue('')->comment('分类列表   逗号分隔'),
            'tagList' => $this->string(800)->defaultValue('')->comment('标签列表 逗号分隔'),
            'sendEmail' => $this->string(64)->notNull()->comment('推送邮箱'),
            'setEmail' => $this->string(64)->notNull()->comment('设置发送方邮箱账号【暂时支持qq邮箱】'),
            'setEmailPwd' => $this->string(255)->notNull()->comment('设置发送方邮箱密码'),
            'setPop3' => $this->string(255)->defaultValue('')->comment('POP3'),
            'setSmtp' => $this->string(255)->defaultValue('')->comment('SMTP'),
            'createtime' => $this->dateTime(),
            'isDelete' => $this->smallInteger(1)->defaultValue(0)
        ]);

        //推送日志
        $this->createTable('JP_knowledgeRecoverySendLog',[
            'userId' => $this->string(8000),
            'krId' => $this->integer(),
            'createtime' => $this->dateTime(),
            'remark' => $this->string(255)
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('JP_knowledgeRecoveryConfig');
        return  $this->dropTable('JP_knowledgeRecoverySendLog');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190214_100215_recoveryconfig cannot be reverted.\n";

        return false;
    }
    */
}
