<?php


use Phinx\Migration\AbstractMigration;

class UserDepartmentIdNull extends AbstractMigration
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
    public function up()
    {
        $table = $this->table( 'User' );
        $table->changeColumn( 'department_id', 'integer', ['null' => true, 'limit' => 10, 'signed' => 0] )
            ->save();
        $this->query('update `User` set `department_id`= NULL where `role_id`!= 3');
    }
    public function down()
    {
        $table = $this->table( 'User' );
        $table->changeColumn( 'department_id', 'integer', ['null' => false, 'limit' => 10, 'signed' => 0] )
            ->save();
    }
}
