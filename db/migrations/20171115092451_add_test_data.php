<?php


use Phinx\Migration\AbstractMigration;

class AddTestdata extends AbstractMigration
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
    /* public function change()
     {


     }
    */
    public function up(){

        //$this->query('TRUNCATE TABLE `User`');
        //$this->query('TRUNCATE TABLE `VisitorMessage`');
        //$this->query('TRUNCATE TABLE UserRole');
        $this->query('delete from `User` where 1');
        $this->query('delete from `Department` where 1');
        $this->query('delete from `UserRole` where 1');
        $this->query('delete from `Visitor` where 1');
        $this->query('delete from `VisitorMessage` where 1');
        $this->query('delete from `Site` where 1');
        //$table = $this->table( 'UserRole' );
        $departments = [
            [
                'department_id'   => 1,
                'department_name' => 'main',
                'description'     => 'Main Department'
            ],
            [
                'department_id'   => 2,
                'department_name' => 'slave',
                'description'     => 'Slave Department'
            ]
        ];
        $roles = [
            [
                'role_id'        => 1,
                'role_name'      => 'owner',
                'description'    => 'Owner of system'
            ],
            [
                'role_id'        => 2,
                'role_name'      => 'admin',
                'description'    => 'Administrator of site'
            ],
            [
                'role_id'        => 3,
                'role_name'      => 'operator',
                'description'    => 'Operator of chats'
            ],

        ];
        $users = [
            [
                'id' => 1,
                'login'         => 'owner1',
                'password'      => '$2y$10$7K0pOF4rjxtmRzXISXas4OSUReCN8EscUWRDz4BpD7dsdZyZV3ati',
                'last_name'     => 'Owner',
                'first_name'    => '#1',
                'is_blocked'    => 0,
                'role_id'       => 1,
                'department_id' => 1
            ],
            [
                'id' => 2,
                'login'         => 'admin',
                'password'      => '$2y$10$VkQa5XkQjQb2Km0KsJJqSOvi6HqVrn5CH8Da2ZqQUkX6LAFaAXU1G',
                'last_name'     => 'Admin',
                'first_name'    => '#1',
                'is_blocked'    => 0,
                'role_id'       => 2,
                'department_id' => 1
            ],
            [
                'id' => 3,
                'login'         => 'operator1',
                'password'      => '$2y$10$SL7s.fLcEEYRlQLdIn064u3VvGbEhkcX1dD8DgtMS2ERuvKINR/Xy',
                'last_name'     => 'Operator',
                'first_name'    => '#1',
                'is_blocked'    => 0,
                'role_id'       => 3,
                'department_id' => 1
            ],
            [
                'id' => 4,
                'login'         => 'operator2',
                'password'      => '$2y$10$SL7s.fLcEEYRlQLdIn064u3VvGbEhkcX1dD8DgtMS2ERuvKINR/Xy',
                'last_name'     => 'Operator',
                'first_name'    => '#2',
                'is_blocked'    => 0,
                'role_id'       => 3,
                'department_id' => 1
            ],
            [
                'id' => 5,
                'login'         => 'owner2',
                'password'      => '$2y$10$7K0pOF4rjxtmRzXISXas4OSUReCN8EscUWRDz4BpD7dsdZyZV3ati',
                'last_name'     => 'Owner',
                'first_name'    => '#2',
                'is_blocked'    => 0,
                'role_id'       => 1,
                'department_id' => 1
            ],

        ];
        $visitors = [
            [
                'visitor_id'   => 1,
                'visitor_name' => 'visitor1',
                'email' => 'visitor@chat.com'
            ],
            [
                'visitor_id'   => 2,
                'visitor_name' => 'visitor2'
            ],
            [
                'visitor_id'   => 3,
                'visitor_name' => 'visitor3'
            ]
        ];
        $visitorsMessages = [
            [
                'id'      => 1,
                'date'    => '2017-11-01 12:00:00',
                'text'    => '{"user":{"id":"3","name":"Operator-1"},"visitor":{"id":"uid-1","name":"Visitor-1"},"messages":[{"3":"Hello","datetime":"2017-11-01 12:00:00"},{"uid-1":"i am visitor-1","datetime":"2017-11-01 12:00:01"}]}',
                'user_id' => 3
            ],
            [
                'id'      => 2,
                'date'    => '2017-11-10 10:00:00',
                'text'    => '{"user":{"id":"3","name":"Operator-1"},"visitor":{"id":"uid-1","name":"Visitor-1"},"messages":[{"3":"Hello","datetime":"2017-11-10 10:00:00"},{"uid-1":"i am visitor-1","datetime":"2017-11-10 10:00:01"}]}',
                'user_id' => 3
            ],
            [
                'id'      => 3,
                'date'    => '2017-11-01 12:00:00',
                'text'    => '{"user":{"id":"4","name":"Operator-2"},"visitor":{"id":"uid-1","name":"Visitor-1"},"messages":[{"4":"Hello","datetime":"2017-11-01 12:00:00"},{"uid-1":"i am visitor-1","datetime":"2017-11-01 12:00:01"}, {"4":"Hello, visitor-1","datetime":"2017-11-01 12:00:02"}]}',
                'user_id' => 4
            ],
            [
                'id'      => 4,
                'date'    => '2017-11-10 10:00:00',
                'text'    => '{"user":{"id":"4","name":"Operator-2"},"visitor":{"id":"uid-2","name":"Visitor-2"},"messages":[{"4":"Hello","datetime":"2017-11-10 10:00:00"},{"uid-2":"i am visitor-2","datetime":"2017-11-10 10:00:01"}]}',
                'user_id' => 4
            ],
            [
                'id'      => 5,
                'date'    => '2017-11-11 11:00:00',
                'text'    => '{"user":{"id":"4","name":"Operator-2"},"visitor":{"id":"uid-3","name":"Visitor-3"},"messages":[{"4":"Hello","datetime":"2017-11-11 11:00:00"},{"uid-3":"i am visitor-3","datetime":"2017-11-11 11:00:01"}]}',
                'user_id' => 4
            ]
        ];

        $sites = [
            [
                'Id'        => 1,
                'site_name'      => 'Test site #1',
                'widget_settings' => '{"color":"blue","logoChatWindow":"logo.png","titleChatWindow":"Chat","chatIcon":"chat.ico","position":4}',
                'owner_id'    => 1
            ],
            [
                'Id'        => 2,
                'site_name'      => 'Test site #2',
                'widget_settings' => '{"color":"blue","logoChatWindow":"logo.png","titleChatWindow":"Chat","chatIcon":"chat.ico","position":4}',
                'owner_id'    => 1
            ],
            [
                'Id'        => 3,
                'site_name'      => 'Test site #3',
                'widget_settings' => '{"color":"blue","logoChatWindow":"logo.png","titleChatWindow":"Chat","chatIcon":"chat.ico","position":4}',
                'owner_id'    => 5
            ],
            [
                'Id'        => 4,
                'site_name'      => 'Test site #4',
                'widget_settings' => '{"color":"blue","logoChatWindow":"logo.png","titleChatWindow":"Chat","chatIcon":"chat.ico","position":4}',
                'owner_id'    => 5
            ],
        ];

        $this->insert('UserRole', $roles);
        $this->insert('Department', $departments);
        $this->insert('User', $users);
        $this->insert('Visitor', $visitors);
        $this->insert('VisitorMessage', $visitorsMessages);
        $this->insert('Site', $sites);
    }
    public function down(){
        $this->query('delete from `User` where 1');
        $this->query('delete from `Department` where 1');
        $this->query('delete from `UserRole` where 1');
        $this->query('delete from `Visitor` where 1');
        $this->query('delete from `VisitorMessage` where 1');
        $this->query('delete from `Site` where 1');
    }
}
