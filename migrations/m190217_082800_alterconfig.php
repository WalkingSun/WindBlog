<?php

use yii\db\Migration;

class m190217_082800_alterconfig extends Migration
{
    public function safeUp()
    {
        $this->addColumn('JP_knowledgeRecoveryConfig','isEnable',$this->smallInteger(1)->comment('是否开启'));
    }

    public function safeDown()
    {
        return  $this->dropColumn('JP_knowledgeRecoveryConfig','isEnable');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190217_082800_alterconfig cannot be reverted.\n";

        return false;
    }
    */
}
