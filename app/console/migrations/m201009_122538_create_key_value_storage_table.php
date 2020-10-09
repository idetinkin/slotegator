<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%key_value_storage}}`.
 */
class m201009_122538_create_key_value_storage_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%key_value_storage}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string()->notNull(),
            'value' => $this->string(),
        ]);

        $this->insert('{{%key_value_storage}}', [
            'key' => 'money_left',
            'value' => '1000000',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%key_value_storage}}');
    }
}
