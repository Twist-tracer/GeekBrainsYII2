<?php

use yii\db\Schema;
use yii\db\Migration;

class m160501_111215_create_calendar extends Migration
{
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `gb_calendar`.`clndr_calendar` (
              `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
              `text` TEXT NOT NULL COMMENT '',
              `creator` INT NOT NULL COMMENT '',
              `date_event` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
              PRIMARY KEY (`id`)  COMMENT '',
              INDEX `fk_evrnt_note_1_idx` (`creator` ASC)  COMMENT '',
              CONSTRAINT `fk_evrnt_note_1`
                FOREIGN KEY (`creator`)
                REFERENCES `gb_calendar`.`clndr_user` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB CHARACTER SET UTF8
        ");
    }

    public function safeDown()
    {
        $this->execute("
            DROP TABLE IF EXISTS `clndr_calendar`;
        ");
    }
}
