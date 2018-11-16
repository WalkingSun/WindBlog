<?php

use yii\db\Migration;

class m181116_054930_alterWBSync extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('JP_gitWindblogSync','createtime',$this->dateTime()->comment('git文件修改时间'));
    }

    public function safeDown()
    {
        $this->dropColumn('JP_gitWindblogSync','createtime');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181116_054930_alterWBSync cannot be reverted.\n";

        return false;
    }
    */
}
