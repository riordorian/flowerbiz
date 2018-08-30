<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180816_191147_smssettings
 */
class m180816_191147_smssettings extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->createTable('sms_settings',[
			'ID' => Schema::TYPE_PK,
			'API_ID' => Schema::TYPE_STRING,
			'ACTIVE' => Schema::TYPE_BOOLEAN
		]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180816_191147_smssettings cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180816_191147_smssettings cannot be reverted.\n";

        return false;
    }
    */
}
