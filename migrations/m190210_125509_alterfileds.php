<?php

use yii\db\Migration;

class m190210_125509_alterfileds extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('JP_blogRecord','cnblogsType',$this->string(255));
        $this->alterColumn('JP_blogRecord','oschinaType',$this->string(255));
        $this->alterColumn('JP_blogRecord','51ctoType',$this->string(255));
        $this->alterColumn('JP_blogRecord','sinaType',$this->string(255));
        $this->alterColumn('JP_blogRecord','csdnType',$this->string(255));
        $this->alterColumn('JP_blogRecord','163Type',$this->string(255));
        $this->alterColumn('JP_blogRecord','chinaunixType',$this->string(255));

    }

    public function safeDown()
    {
        echo "m190210_125509_alterfileds cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190210_125509_alterfileds cannot be reverted.\n";

        return false;
    }
    */
}
