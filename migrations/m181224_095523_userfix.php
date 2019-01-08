<?php

use yii\db\Migration;

class m181224_095523_userfix extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('JP_user','mobile',$this->integer(11));
    }

    public function safeDown()
    {


        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181224_095523_userfix cannot be reverted.\n";

        return false;
    }
    */
}
