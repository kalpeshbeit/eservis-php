<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');     

class Profil extends My_model {


    public function getOperater(){
        $sql="SELECT operater.* FROM operater
            where firma_fi_id =". $this->session->userdata('firmaID');

        $query = $this->db->query($sql);
        return $query->result();
    } 
    
    
    public function operaterOsvjezi($id) {
        $this->db->select('operater.*, firma.fi_naziv, firma.fi_id');
        $this->db->from('operater');
        $this->db->join('firma', 'firma.fi_id = operater.firma_fi_id'); 
        $this->db->where('operater.op_id', $id);


        $query = $this->db->get();
        $result = $query->result();
        $osoba = $result[0];

        $data = array(
            'is_logged_in'      =>  1,
            'id_osoba'          =>  $osoba->op_id,
            'email'             =>  $osoba->op_mail,
            'ime'               =>  $osoba->op_ime,
            'prezime'           =>  $osoba->op_prezime,
            'firma'             =>  $osoba->fi_naziv,
            'firmaID'           =>  $osoba->fi_id,
            'nivo'              =>  $osoba->op_nivo,
            'slika'             =>  $osoba->op_avatar
        );
        $this->session->set_userdata($data);
    }
}

?>