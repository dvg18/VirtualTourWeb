<?php


use Phinx\Migration\AbstractMigration;

class RenameOperatorsSites extends AbstractMigration
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
        $this->query("update `UserRole` set `description`='Administrator of system' where `role_id`=2");
        $this->query("update `UserRole` set `description`='Owner of site' where `role_id`=1");
        $this->query("update `Site` set `site_name`='teamlab-srv.oft-e.com' where `id`=1");
        $this->query("update `Site` set `site_name`='smartbiz24.ru' where `id`=2");
        $this->query("update `Site` set `site_name`='yandex.ru' where `id`=3");
        $this->query("update `Site` set `site_name`='google.com' where `id`=4");
        $this->query("update `User` set `first_name`='Witaliy' where `id`=1");
        $this->query("update `User` set `first_name`='Victor' where `id`=2");
        $this->query("update `User` set `first_name`='Peter' where `id`=3");
        $this->query("update `User` set `first_name`='Sergey' where `id`=4");
        $this->query("update `User` set `first_name`='Igor' where `id`=5");
    }
}
