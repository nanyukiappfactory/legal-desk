<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_partner extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'partner_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
           
            'partner_type_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => FALSE,
            ),
            'partner_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'partner_email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'partner_logo' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
           
        
        ));
       
        $this->dbforge->add_field("`created_by` int NOT NULL ");
        $this->dbforge->add_field("`created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`modified_by` int  NULL ");
        $this->dbforge->add_field("`modified_on` timestamp  NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`deleted_by` int  NULL");
        $this->dbforge->add_field("`deleted` tinyint NOT NULL DEFAULT 0");
        $this->dbforge->add_field("`deleted_on` timestamp NULL DEFAULT NULL");
        $this->dbforge->add_key('partner_id', TRUE);
        $this->dbforge->create_table('partner');
       // $this->db->query('ALTER TABLE `partner` ADD FOREIGN KEY(`partner_type_id`) REFERENCES `partner_type`(`partner_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;');
       
    }

    public function down()
    {
            $this->dbforge->drop_table('partner');
    }
}