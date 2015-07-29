<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Registracija_model extends My_model {


    public function post_validacija($table,$id) {
        
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));

        switch ($table) {
            case 'operater':
     
                $this->form_validation->set_rules('ime', 'Ime', 'trim|required|min_length[3]|max_length[25]|xss_clean');
                $this->form_validation->set_rules('prezime', 'Prezime', 'trim|required|min_length[3]|max_length[30]|xss_clean');
                
                
                if(!$id)
                {
                    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|unique_2[operater.op_mail]|xss_clean');
                    $this->form_validation->set_rules('password', 'Lozinka', 'required|matches[confirmPassword]|xss_clean');
                    $this->form_validation->set_rules('confirmPassword', 'Lozinka potvrde', 'required|xss_clean');
                }
                else
                {    
                    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|unique_3['.$id.']|xss_clean');
                    $this->form_validation->set_rules('oib', 'Oib', 'required|min_length[11]|max_length[11]|xss_clean');                     
                }

                break;
                     
            case 'firma':
                $this->form_validation->set_rules('naziv', 'Naziv', 'trim|required|min_length[1]|max_length[15]|xss_clean'); 
                $this->form_validation->set_rules('oib', 'Oib', 'required|min_length[11]|max_length[11]|xss_clean');
                //$this->form_validation->set_rules('mjesto', 'Mjesto', 'trim|required|min_length[1]|max_length[45]|xss_clean');
                //$this->form_validation->set_rules('posta', 'Posta', 'trim|required|min_length[1]|max_length[5]|xss_clean');
                break;
        }


        if ($this->form_validation->run()) {
            switch ($table) {
                  case 'operater':

                        //insert
                         $data = array(  
                        'op_ime'            => $this->input->post('ime'),
                        'op_prezime'        => $this->input->post('prezime'),
                        'op_mail'           => $this->input->post('email'),          
                        'op_oib'            => $this->input->post('oib'),              
                        'op_telefon'        => $this->input->post('telefon'),              
                        'firma_fi_id'       => $this->input->post('id_firma'),
                        'op_code'           => NULL
                        );               
                    
                    break;
                    
                 case 'firma':
                 
                    $data = array(
                        'fi_oib'             => $this->input->post('oib'),
                        'fi_naziv'           => $this->input->post('naziv'),    
                        'fi_adresa'          => $this->input->post('adresa'),    
                        'fi_posta'           => $this->input->post('posta'),    
                        'fi_mjesto'          => $this->input->post('mjesto'),    
                        'fi_iban'            => $this->input->post('iban'),      
                        'fi_mail'            => $this->input->post('mail'),            
                        'fi_usustavuPDV'     => $this->input->post('sustavPDV'),
                        'fi_opis'            => $this->input->post('opis'),
                        'fi_registracijado'  => date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month" ) )  
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
