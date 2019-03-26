<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_partner_type extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'partner_type_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
           
            'partner_type_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE,
            ),
            'partner_type_status' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => FALSE,
            ),
        
            
        ));
       
        $this->dbforge->add_field("`created_by` int  NULL ");
        $this->dbforge->add_field("`created_on` datetime  NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`modified_by` int NULL ");
        $this->dbforge->add_field("`modified_on` timestamp  NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`deleted_by` int  NULL");
        $this->dbforge->add_field("`deleted` tinyint  NULL DEFAULT 0");
        $this->dbforge->add_field("`deleted_on` timestamp NULL ");
        $this->dbforge->add_key('partner_type_id', TRUE);
        $this->dbforge->create_table('partner_type');
       // $this->db->query('ALTER TABLE `partner_type` ADD FOREIGN KEY(`partner_type_type_id`) REFERENCES `partner_type_type`(`partner_type_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;');
       $this->db->query('INSERT INTO `partner_type` (partner_type_name, partner_type_status, created_by,  created_on, modified_by, modified_on, deleted_by, deleted, deleted_on) VALUES ("Donor", 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');
       $this->db->query('INSERT INTO `partner_type` (partner_type_name, partner_type_status, created_by,  created_on, modified_by, modified_on, deleted_by, deleted, deleted_on) VALUES ("Partner", 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);');
    }

    public function down()
    {
            $this->dbforge->drop_table('partner_type');
    }
}