<?php

use yii\db\Migration;

class m190213_024102_KnowledgeRecovery extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="jump"';
        }

        $this->createTable('JP_knowledgeRecovery',[
            'id' => $this->primaryKey(),
            'userId' => $this->string(8000),
            'title' => $this->string(255)->notNull(),
            'content' => $this->string(2000)->defaultValue('')->comment('内容'),
            'href' => $this->string(255)->defaultValue(''),
            'tag' =>  $this->string(255)->defaultValue('')->comment('标签'),
            'type' => $this->string(255)->defaultValue('')->comment('分类'),
            'frequency' => $this->string(100)->defaultValue(''),  //格式类似crontab
            'remark' => $this->string(255)->defaultValue(''),
            'createtime' => $this->dateTime(),
            'updatetime' => $this->dateTime(),
            'isDelete' => $this->smallInteger(1)->defaultValue(0)
        ]);

        $this->addColumn('JP_user','email',$this->string(65)->defaultValue('')->comment('邮箱地址'));
    }

    public function safeDown()
    {
        $this->dropColumn('JP_user','email');
        return $this->dropTable('JP_knowledgeRecovery');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190213_024102_KnowledgeRecovery cannot be reverted.\n";

        return false;
    }
    */
}
