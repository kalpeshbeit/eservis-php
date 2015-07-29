<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_model extends CI_Model {

    /**
    * Select * from table or select where $column == $value
    * @return array
    */
	public function getFromTable($table, $column = null, $value = null, $order = null, $order_by = null, $limit = null) {
        $this->db->select('*');
        $this->db->from($table);
        if (!is_null( $column ) && !is_null($value)) {
            $this->db->where($column, $value);
        }
        if (!is_null($order) && !is_null($order_by)){
            $this->db->order_by($order, $order_by);    
        }
        if (!is_null($limit)){
            if (is_int($limit) === TRUE){
                $this->db->limit($limit); 
            }             
        }

        $query = $this->db->get();
        return $query->result();
    }


    /**
    * Get row by ID
    * @return row
    */
    public function getById($table, $column, $value,  $column2 = null, $value2 = null) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($column, $value);
        
        if (!is_null($column2) && !is_null($value2)) {
            $this->db->where($column2, $value2);
        }
        
        $query = $this->db->get();
        $result = $query->result();
        return $result[0];
    }


    /**
     * @param $table
     * @param $data
     * @return bool
     */
    public function create($table, $data) {  
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    /**
     * @param $table
     * @param $column
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($table, $column, $id, $data) {
        $this->db->where($column, $id);
        $this->db->update($table, $data);

        return ($this -> db -> affected_rows() > 0) ? TRUE : FALSE;
    }

    /**
     * @param $id
     * @return bool
     * Brisanje
     */
    public function delete($table, $column, $value, $column2 = null, $value2 = null) {
        $this->db->where($column, $value);
        if (!is_null($column) && !is_null($value2)) {
            $this->db->where($column2, $value2);
        }
        $this->db->delete($table);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }


    /**
     * @param $table, $column, $value
     * @return number of rows
     */
    public function getNumRows($table, $column = null, $value = null, $column2 = null, $value2 = null, $column3 = null, $value3 = null){
        $this->db->select('*');
        $this->db->from($table);
        if (!is_null($column) && !is_null($value)) {
            $this->db->where($column, $value);
        }
        if (!is_null($column2) && !is_null($value2)) {
            $this->db->where($column2, $value2);
        }
        if (!is_null($column3)) {
            $this->db->where($column3, $value3);
        }
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function send_email($to, $from, $from_name = NULL, $subject, $msg){
        $this->load->library('email');
        
        $this->email->from($from, $from_name);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($msg);

        return ($this->email->send()) ? TRUE : FALSE;
    }


     public function getWhere($table, $column, $value, $column2 = null, $value2 = null) {
        $this->db->select('*');
        $this->db->from($table);
        if (!is_null($column) && !is_null($value)) {
            $this->db->where($column, $value);
        }
        if (!is_null($column2) && !is_null($value2)) {
            $this->db->where($column2, $value2);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function getWhereArray($table, $column, $value, $column2 = null, $value2 = null,$order = null, $order_by = null) {
        $this->db->select('*');
        $this->db->from($table);
        if (!is_null($column) && !is_null($value)) {
            $this->db->where($column, $value);
        }
        if (!is_null($column2) && !is_null($value2)) {
            $this->db->where($column2, $value2);
        }

        if (!is_null($order) && !is_null($order_by)){
            $this->db->order_by($order, $order_by);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
	
}