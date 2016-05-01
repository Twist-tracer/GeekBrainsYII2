<?php

use yii\db\Schema;
use yii\db\Migration;

class m160501_111231_create_access extends Migration
{
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `gb_calendar`.`clndr_access` (
              `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
              `user_owner` INT NOT NULL COMMENT '',
              `user_guest` INT NOT NULL COMMENT '',
              `date` DATE NOT NULL COMMENT '',
              PRIMARY KEY (`id`)  COMMENT '',
              INDEX `fk_clndr_access_1_idx` (`user_owner` ASC)  COMMENT '',
              INDEX `fk_clndr_access_2_idx` (`user_guest` ASC)  COMMENT '',
              CONSTRAINT `fk_clndr_access_1`
                FOREIGN KEY (`user_owner`)
                REFERENCES `gb_calendar`.`clndr_user` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_clndr_access_2`
                FOREIGN KEY (`user_guest`)
                REFERENCES `gb_calendar`.`clndr_user` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB CHARACTER SET UTF8;
        ");
    }

    public function safeDown()
    {
        $this->execute("
            DROP TABLE IF EXISTS `clndr_access`;
        ");
    }
}
