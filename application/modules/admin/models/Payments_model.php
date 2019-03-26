<?php

class Payments_model extends CI_Model
{
    /*
     *    Retrieve all sections
     *    @param string $table
     *     @param string $where
     *
     */
    public function get_all_payments($table, $where, $per_page, $page, $order = 'mpesalipatransaction_id', $order_method = 'DESC')
    {
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($order, $order_method);
        $query = $this->db->get('', $per_page, $page);

        return $query;
    }

    public function get_result_codes()
    {
        $this->db->distinct('resultCode');
        $this->db->select('resultCode');
        $this->db->order_by('resultCode', "ASC");
        $query = $this->db->get("mpesalipatransaction");

        return $query;
    }

    public function get_transacted_customers()
    {
        $this->db->distinct('msisdn');
        $this->db->select('msisdn');
        $this->db->order_by('msisdn', "ASC");
        $query = $this->db->get("mpesalipatransaction");

        return $query;
    }

    public function delete_payment($mpesalipatransaction_id)
    {
        $this->db->where("mpesalipatransaction_id", $mpesalipatransaction_id);
        if ($this->db->delete("mpesalipatransaction")) {
            return true;
        } else {
            return false;
        }
    }

    public function isp_update_payment($mpesalipatransaction_id)
    {
        include realpath(APPPATH . '../updates-webservice/Connection.php');

        $conn = new Connection();

        //Get payment
        $this->db->where("mpesalipatransaction_id", $mpesalipatransaction_id);
        $query = $this->db->get("mpesalipatransaction");

        if($query->num_rows() > 0)
        {
            $res = $query->row();
            $phone_number = $res->msisdn;

            //2. Select all mpesaLipaTransaction with greater ids than $max_id from Postgres
            $sql = 'SELECT * FROM "public"."mpesaLipaTransaction" WHERE "msisdn" = \'' . $phone_number . '\' AND "resultReceived" >= \'2019-02-01\' LIMIT 100';
            // var_dump($sql); die();
    
            $mpesa_lipa_transaction = $conn->select_items($sql);
    
            // var_dump($mpesa_lipa_transaction); die();
    
            if (is_array($mpesa_lipa_transaction)) {
                $total_mpesa_lipa_transaction = count($mpesa_lipa_transaction);
                $count = $total_mpesa_lipa_transaction;
                $total_saved = 0;
                $multi_query = "";
                //3. Insert new mpesaLipaTransaction
                if ($total_mpesa_lipa_transaction > 0) {
                    for ($r = 0; $r < $total_mpesa_lipa_transaction; $r++) {
                        $row = $mpesa_lipa_transaction[$r];
    
                        if ($conn->mpesa_lipa_transaction_exists($row["id"]) == false) {
    
                            $total_saved++;
                            $multi_query .= "INSERT INTO mpesalipatransaction (id, customerId, ticketId, status, amount, msisdn, merchantRequestID, checkoutRequestID, responseDescription, responseCode, customerMessage, responseReceived, resultDesc, resultCode, resultReceived, errorCode, errorMessage, requestPackage, category, agentId, routerId, mpesaReceiptNumber) VALUES ('" . $row["id"] . "','" . $row["customerId"] . "','" . $row["ticketId"] . "','" . $row["status"] . "','" . $row["amount"] . "','" . $row["msisdn"] . "','" . $row["merchantRequestID"] . "','" . $row["checkoutRequestID"] . "','" . $row["responseDescription"] . "','" . $row["responseCode"] . "','" . $row["customerMessage"] . "','" . $row["responseReceived"] . "','" . $row["resultDesc"] . "','" . $row["resultCode"] . "','" . $row["resultReceived"] . "','" . $row["errorCode"] . "','" . $row["errorMessage"] . "','" . $row["requestPackage"] . "','" . $row["category"] . "','" . $row["agentId"] . "','" . $row["routerId"] . "', '" . $row["mpesaReceiptNumber"] . "');";
                            // var_dump($multi_query); die();
                        } else {
                            $message = $count . " mpesa-transaction(s) not saved";
                            echo "<span style='color:red;'>" . $row["amount"] . " " . $row["id"] . " already exists </span><br/>";
                        }
                    }
    
                    //4. Multi insert into the database
                    $result = $conn->multi_query_statement($multi_query);
                    if ($result == true) {
                        $message = $total_saved . " mpesa-transaction(s) saved";
                        echo $total_saved . " mpesa-transaction(s) saved<br/>";
                    } else {
                        $message = $total_saved . " mpesa-transaction(s) not saved";
                        echo "<span style='color:red;'>" . $total_saved . " mpesa-transaction(s) not saved </span><br/>";
                    }
                } else {
                    $message = "No new mpesaLipaTransaction found";
                    echo "<span style='color:red;'>No new mpesaLipaTransaction found </span><br/>";
                }
            } else {
                $message = "No new mpesaLipaTransaction found";
                echo "<span style='color:red;'>No new mpesaLipaTransaction found </span><br/>";
            }
        }

        else
        {
            $message = "Transaction not found in MySQL";
        }
    }
}
