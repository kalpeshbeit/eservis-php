<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');     

class Korisnik extends My_model {

    public function login($email, $password) { 
        $this->db->select('operater.*, firma.*');
        $this->db->from('operater');
        $this->db->join('firma', 'firma.fi_id = operater.firma_fi_id'); 
        $this->db->where('operater.op_mail', $email);
        $this->db->where('operater.op_lozinka', $password);

        $query = $this->db->get();
        $result = $query->result();
        $osoba = $result[0];
        
        //ako je broj preostalih dana koristenja manji od 0 sto znaci trenutni datum ne dozvoli dodavanje racuna
        if(floor((strtotime($osoba->fi_registracijado) - strtotime(date('Y-m-d')))/ (60*60*24))  < 0)
        {
             $licenca =  0;
        }
        else
        {
            $licenca  =  1; 
        }

           
        $data = array(  
            'is_logged_in'      =>  1,
            'id_osoba'          =>  $osoba->op_id,
            'email'             =>  $this->input->post('op_mail'),
            'ime'               =>  $osoba->op_ime,
            'prezime'           =>  $osoba->op_prezime,
            'firma'             =>  $osoba->fi_naziv,
            'firmaID'           =>  $osoba->fi_id,
            'licencaVrijediDo'  =>  $osoba->fi_registracijado,
            'firma_mjesto'      =>  $osoba->fi_mjesto,
            'UsustavuPDV'       =>  $osoba->fi_usustavuPDV,
            'nivo'              =>  $osoba->op_nivo,
            'slika'             =>  $osoba->op_avatar,
            'licenca_ispravna'  => $licenca
        );
        $this->session->set_userdata($data);  
    }
    
    public function getRegistered($token)
    {
        $sql="SELECT operater.* FROM operater  
            where op_code = '$token'" ; 

        $query = $this->db->query($sql);
        $result = $query->result();
        return $result[0];          
    } 
}   

?>
