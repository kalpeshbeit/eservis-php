<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MY_Form_validation Class
 *
 * Extends Form_Validation library
 *
 * Adds one validation rule, "unique" and accepts a
 * parameter, the name of the table and column that
 * you are checking, specified in the forum table.column
 *
 * Note that this update should be used with the
 * form_validation library introduced in CI 1.7.0
 */
class MY_Form_validation extends CI_Form_validation {

    function __construct()
    {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    /**
     * Unique
     *
     * @access    public
     * @param    string
     * @param    field
     * @return    bool
     */
     
     //provjera da li nesto postoji na razini firme
    function unique($str, $field)
    {
        $CI =& get_instance();
        list($table, $column) = explode('.', $field, 2);

        $CI->form_validation->set_message('unique', '%s koju ste upisali vec postoji.');

        $query = $CI->db->query("SELECT COUNT(*) AS broj FROM $table WHERE $column = '$str' and $table.firma_fi_id =".$CI->session->userdata('firmaID'));   
        $row = $query->row();
        return ($row->broj > 0) ? FALSE : TRUE;
    }    
    
    //provjera da li postoji email prilikom registracije
    function unique_2($str, $field)
    {
        $CI =& get_instance();
        list($table, $column) = explode('.', $field, 2);

        $CI->form_validation->set_message('unique_2', '%s koju ste upisali vec postoji.');

        $query = $CI->db->query("SELECT COUNT(*) AS broj FROM $table WHERE $column = '$str' ");   
        $row = $query->row();
        return ($row->broj > 0) ? FALSE : TRUE;
    }
    
    
    //provjera da li e mail postoji ukoliko ga mijenjate kod nekog od korisnika   
    function unique_3($str, $field)
    {
        $CI =& get_instance();
        list($table, $column) = explode('.', $field.'.');
                            

        $CI->form_validation->set_message('unique_3', '%s koju ste upisali vec postoji. Odaberite drugi!');

        $query = $CI->db->query("SELECT COUNT(*) AS broj FROM operater WHERE operater.op_mail = '$str' and operater.op_id != $table ");   
        $row = $query->row();
        return ($row->broj > 0) ? FALSE : TRUE;  
    } 

}
?>