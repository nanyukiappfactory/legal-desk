<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_person extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'person_id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'person_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'person_description' => array(
                                'type' => 'TEXT',
                                'null' => TRUE,
                        ),
                ));
                $this->dbforge->add_key('person_id', TRUE);
                $this->dbforge->create_table('persons');
        }

        public function down()
        {
                $this->dbforge->drop_table('persons');
        }
}