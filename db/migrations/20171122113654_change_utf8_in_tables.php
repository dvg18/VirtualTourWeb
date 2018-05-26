<?php


use Phinx\Migration\AbstractMigration;

class ChangeUtf8InTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->query('ALTER TABLE `OFTEAMCHAT`.`Department` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;');
        $this->query('ALTER TABLE `OFTEAMCHAT`.`Site` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;');
        $this->query('ALTER TABLE `OFTEAMCHAT`.`User` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;');
        $this->query('ALTER TABLE `OFTEAMCHAT`.`UserRole` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;');
        $this->query('ALTER TABLE `OFTEAMCHAT`.`UserTimetable` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;');
        $this->query('ALTER TABLE `OFTEAMCHAT`.`Visitor` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;');
        $this->query('ALTER TABLE `OFTEAMCHAT`.`VisitorMessage` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;');
    }
}
