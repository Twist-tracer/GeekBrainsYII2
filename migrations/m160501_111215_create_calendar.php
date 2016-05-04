<?php

use yii\db\Schema;
use yii\db\Migration;

class m160501_111215_create_calendar extends Migration
{
    public function safeUp()
    {
        $this->createTable('clndr_calendar', [
            'id' => $this->primaryKey(),
            'text' => $this->text()->notNull(),
            'creator' => $this->integer(11)->notNull(),
            'date_event_start' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'date_event_end' => $this->dateTime()->defaultExpression('NULL'),
        ]);
        $this->addForeignKey('FK_creator', 'clndr_calendar', 'creator', 'clndr_user', 'id', 'NO ACTION', 'NO ACTION');
    }

    public function safeDown()
    {
        $this->dropTable('clndr_calendar');
    }
}
