<?php


use Phinx\Migration\AbstractMigration;

class AddTestData extends AbstractMigration
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
        $this->query('delete from `User` where 1');
        $this->query('delete from `UserRole` where 1');
        $roles = [
            [
                'id' => 1,
                'role_name' => 'admin',
                'description' => 'Administrator of the site'
            ],
            [
                'id' => 2,
                'role_name' => 'user',
                'description' => 'User of the site'
            ],
        ];
        $users = [
            [
                'id' => 1,
                'login' => 'admin',
                'password' => '$2y$10$VkQa5XkQjQb2Km0KsJJqSOvi6HqVrn5CH8Da2ZqQUkX6LAFaAXU1G',
                'last_name' => 'Gerasimov',
                'first_name' => 'Dmitriy',
                'role_id' => 1,
            ],
        ];

        $this->insert('UserRole', $roles);
        $this->insert('User', $users);
    }

    public function down()
    {
        $this->query('delete from `User` where 1');
        $this->query('delete from `UserRole` where 1');
    }
}
