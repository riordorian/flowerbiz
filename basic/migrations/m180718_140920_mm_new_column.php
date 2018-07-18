<?php

use yii\db\Migration;

/**
 * Class m180718_140920_mm_new_column
 */
class m180718_140920_mm_new_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->addColumn('money_movements', 'ENCASHMENT', $this->boolean());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180718_140920_mm_new_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180718_140920_mm_new_column cannot be reverted.\n";

        return false;
    }
    */
}
