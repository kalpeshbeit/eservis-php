<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');     

class Postavka extends My_model {


    public function getProdajnoMjesto(){
        $sql="SELECT prodajnomjesto.* FROM prodajnomjesto
            where firma_fi_id =". $this->session->userdata('firmaID');

        $query = $this->db->query($sql);
        return $query->result();
    }    
    
    
    public function getProdajnoMjestoID($id){
        $sql="SELECT prodajnomjesto.* FROM prodajnomjesto
            where firma_fi_id =". $this->session->userdata('firmaID')." and pm_id =" .$id ." and pm_zatvoreno = 0";

        $query = $this->db->query($sql);
        return $query->result();
    }
    
    
    
    
    public function getNaplatniUredaj(){
        $sql="SELECT naplatniuredjaj.*, prodajnomjesto.pm_oznaka  FROM naplatniuredjaj left join prodajnomjesto on prodajnomjesto.pm_id = naplatniuredjaj.prodajnoMjesto_pm_id where prodajnomjesto.firma_fi_id =". $this->session->userdata('firmaID');

        $query = $this->db->query($sql);
        return $query->result();
    } 
    
    
    public function getNaplatniUredjajID($idPP){
        $sql="SELECT naplatniuredjaj_nu_id  FROM dokument where naplatniuredjaj_nu_id =" .$idPP ." and firma_fi_id =". $this->session->userdata('firmaID');

        $query = $this->db->query($sql);
        return $query->result();
    }
    
    
    public function getCertifikat(){
        $sql="SELECT fi_certifikat, fi_pass  FROM firma where fi_id =". $this->session->userdata('firmaID')." and fi_certifikat is not null";

        $query = $this->db->query($sql);
        $result = $query->result();
         
         if(!$result)
         {
             return NULL;
         }
         else
         {
            return $result[0];
         }
    }
    
    function encrypt($input) {
        return base64_encode($input);
    }
    
    function decrypt($input) {
    
        return trim( base64_decode($input));
    }

 
     public function post_validacija($table) { 
        
        $this->load->library('form_validation');

        switch ($table) {
            case 'certifikat':
                $this->form_validation->set_rules('lozinka', 'Lozinka', 'trim|required|min_length[1]|max_length[40]|xss_clean');
                break;
        }

        
        $input = $this->input->post('lozinka');

        //$encrypted = encryptIt( $input );
        //$decrypted = decryptIt( $encrypted );
 
        
        if ($this->form_validation->run()) {
            switch ($table) {
                case 'certifikat':
                    $data = array(  
                        'fi_pass'            => $this->encrypt($this->input->post('lozinka'))   
                    );
                break;
            }
            return $data;

        } else {
            return FALSE;
        }
    }
  
}

?>