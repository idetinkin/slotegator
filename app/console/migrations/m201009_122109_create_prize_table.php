<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prize}}`.
 */
class m201009_122109_create_prize_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createPrizeTypeTable();

        $this->createPrizeStatusTable();

        $this->createPrizeThingTable();

        $this->createPrizeTable();
    }

    private function createPrizeTypeTable()
    {
        $this->createTable('{{%prize_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        $this->insert('{{%prize_type}}', [
            'id' => 1,
            'name' => 'Money',
        ]);
        $this->insert('{{%prize_type}}', [
            'id' => 2,
            'name' => 'Points',
        ]);
        $this->insert('{{%prize_type}}', [
            'id' => 3,
            'name' => 'Things',
        ]);
    }

    private function createPrizeStatusTable()
    {
        $this->createTable('{{%prize_status}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        $this->insert('{{%prize_status}}', [
            'id' => 1,
            'name' => 'New',
        ]);
        $this->insert('{{%prize_status}}', [
            'id' => 2,
            'name' => 'Delivered',
        ]);
    }

    private function createPrizeThingTable()
    {
        $this->createTable('{{%prize_thing}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'qty' => $this->integer(),
        ]);

        $this->insert('{{%prize_thing}}', [
            'name' => 'TV',
            'qty' => 1000,
        ]);
        $this->insert('{{prize_thing}}', [
            'name' => 'Car',
            'qty' => 1000,
        ]);
        $this->insert('{{prize_thing}}', [
            'name' => 'Turtle',
            'qty' => 1000,
        ]);
        $this->insert('{{prize_thing}}', [
            'name' => 'Hug',
            'qty' => 1000,
        ]);
    }

    private function createPrizeTable()
    {
        $this->createTable('{{%prize}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'value' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('prize_fk_user', '{{%prize}}', 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('prize_fk_type', '{{%prize}}', 'type_id', '{{%prize_type}}', 'id');
        $this->addForeignKey('prize_fk_status', '{{%prize}}', 'status_id', '{{%prize_status}}', 'id');

        $this->createIndex('prize_user_indx', '{{%prize}}', 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prize}}');
        $this->dropTable('{{%prize_thing}}');
        $this->dropTable('{{%prize_status}}');
        $this->dropTable('{{%prize_type}}');
    }
}
