<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_donation extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'donation_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'donation_amount' => array(
                'type' => 'DOUBLE',
                'null' => TRUE,
            ),
            'partner_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => FALSE,
            ),
            'school_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => TRUE
            )
        ));
        $this->dbforge->add_field("`created_by` int NOT NULL");
        $this->dbforge->add_field("`donation_status` tinyint NOT NULL");
        $this->dbforge->add_field("`created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`modified_by` int NULL ");
        $this->dbforge->add_field("`modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`deleted_by` int NULL");
        $this->dbforge->add_field("`deleted` tinyint NOT NULL DEFAULT 0");
        $this->dbforge->add_field("`deleted_on` timestamp NULL DEFAULT NULL");
        $this->dbforge->add_key('donation_id', TRUE);
        $this->dbforge->create_table('donation');
        // $this->db->query('INSERT INTO `donation` (donation_amount, partner_id, school_id, created_by, donation_status, created_on, modified_by, modified_on, deleted_by, deleted, deleted_on) VALUES (100000, 1, 2, 3, 1, "2019-02-12 17:00:23", "2019-02-12 17:00:23", 2, "2019-02-12 17:00:23", 0, "2019-02-12 17:00:23");;');
    }

    public function down()
    {
            $this->dbforge->drop_table('donation');
    }
}