<?php

use yii\db\Migration;

class m161011_165617_urlImg extends Migration
{
    public function up()
    {
        $this->createTable('urlImg', [
            'id' => $this->primaryKey(),
            'url' => $this->string(),
            'date' => $this->dateTime(),
            'data' => $this->text()
        ]);
    }

    public function down()
    {
        echo "m161011_165617_urlImg cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
