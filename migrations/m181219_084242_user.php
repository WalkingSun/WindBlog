<?php

use yii\db\Migration;

class m181219_084242_user extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="菜单表"';
        }

        $this->createTable('JP_ser', [
            'userId' => $this->primaryKey(),
            'mobile' => $this->integer(11)->notNull(),
            'password' => $this->string(64)->notNull(),
            'username' => $this->string(255)->notNull(),
            'nickname' => $this->string(255)->notNull(),
            'desc' => $this->string(255)->defaultValue(''),
            'remark' => $this->string(255)->defaultValue(''),
            'salt' => $this->string(64)->defaultValue(''),
            'isDelete' => $this->smallInteger(2)->defaultValue(0),
        ],$tableOptions);

        $this->addColumn('JP_blogConfig','userId',$this->string(8000)->notNull()->defaultValue('super'));
        $this->addColumn('JP_blogRecord','userId',$this->string(8000)->notNull()->defaultValue('super'));
        $this->addColumn('JP_blogCategories','userId',$this->string(8000)->notNull()->defaultValue('super'));

    }

    public function safeDown()
    {
        $this->dropTable('JP_user');
        $this->dropColumn('JP_blogConfig','userId');
        $this->dropColumn('JP_blogRecord','userId');
        $this->dropColumn('JP_blogCategories','userId');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181219_084242_user cannot be reverted.\n";

        return false;
    }
    */
}
