<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_school extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'school_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'school_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'school_latitude' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'school_longitude' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'school_girls_number' => array(
                'type' => 'INT',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'school_boys_number' => array(
                'type' => 'INT',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'school_write_up' => array(
                'type' => 'VARCHAR',
                'null' => FALSE,
                'default' => NULL,
            ),
            'school_write_up' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
                'default' => NULL,
            ),
            'school_picture_id' => array(
                'type' => 'INT',
                'constraint' => '100',
                'null' => TRUE,
                'default' => NULL,
            ),
            'school_status' => array(
                'type' => 'BOOLEAN',
                'null' => FALSE,
                'default' => 0,
            ),
        ));
        $this->dbforge->add_field("`created_by` int NOT NULL");
        $this->dbforge->add_field("`created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`modified_by` int NULL ");
        $this->dbforge->add_field("`modified_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`deleted_by` int NULL");
        $this->dbforge->add_field("`deleted` tinyint NOT NULL DEFAULT 0");
        $this->dbforge->add_field("`deleted_on` timestamp NULL DEFAULT NULL");
        $this->dbforge->add_key('school_id', TRUE);
        $this->dbforge->create_table('school');
    }

    public function down()
    {
            $this->dbforge->drop_table('school');
    }
}