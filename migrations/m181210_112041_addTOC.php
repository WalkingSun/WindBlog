<?php

use yii\db\Migration;

class m181210_112041_addTOC extends Migration
{
    public function safeUp()
    {

        $this->addColumn('JP_blogConfig','isTOC',$this->smallInteger()->defaultValue(0)->comment('是否添加TOC'));

    }

    public function safeDown()
    {
        $this->dropColumn('JP_blogConfig','isTOC');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181210_112041_addTOC cannot be reverted.\n";

        return false;
    }
    */
}
