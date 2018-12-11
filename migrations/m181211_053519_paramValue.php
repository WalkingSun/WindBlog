<?php

use yii\db\Migration;

class m181211_053519_paramValue extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="参数表"';
        }

        $this->createTable('JP_paramValue', [
            'id' => $this->primaryKey(),
            'userId' => $this->string()->notNull()->comment('用户id'),
            'param' => $this->string(16)->notNull()->comment('参数'),
            'desc' => $this->string(64)->comment('描述'),
            'value' => $this->string(64)->notNull()->comment('值'),
            'value2' => $this->string(64)->comment('值2'),
            'value3' => $this->string(64)->comment('值3'),
            'value4' => $this->string(64)->comment('值4'),
            'value5' => $this->string(64)->comment('值5'),
            'remark' => $this->string(255)->comment('备注'),
            'createtime' => $this->dateTime(),
            'isDelete' => $this->smallInteger(2)->defaultValue(0)
            ],$tableOptions);

    }

    public function safeDown()
    {
       $this->dropTable('JP_paramValue');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181211_053519_paramValue cannot be reverted.\n";

        return false;
    }
    */
}
