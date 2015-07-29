<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
  
  
  class Registracija extends CI_Controller
  {
      public function __construct()
      {
        parent::__construct();

        $this->load->model('korisnik');       
        $this->load->model('registracija_model');       
      }

    /**
     * Shows the admin dashboard page
     * 
     * This is the default action for admin Dashboard controller. This function shows the admin dashboard page.
     */
     

     
      public function token($token) 
     {
        //pokupi pdatke na osnovu CODA iz urla 
        
        
        //dohvati ime i prezime korisnika koji se hoæe registrirati i pošalji ga u template/register
        $korisnik = $this->korisnik->getRegistered($token);

        if($korisnik)
        {
            # Store stats in $data
            $data = array(
                'korisnik'    =>  $korisnik  
            );   
            
            
            $this->session->set_userdata('register', 1);  
           
           //pozovi header od aplikacije ali modificirani 
            $this->load->templateregister($data);   
        }
        else
        {  
            $this->session->set_userdata('register', 1);    
            //nepostojeci token 
            //poruka da pokusaju ponovno kliknuti na link u emailu i nastaviti registraciju
            $this->session->set_flashdata('register_alert', 'PokuÅ¡ajte se ulogirati email i lozinkom koje ste odabrali!. ');          
            redirect(base_url());
        }
     
     }
     
    public function process_form($table)
    {
        $id = $this->input->post('id');
        
        //Set some validation rules
                       
        $data = $this->registracija_model->post_validacija($table, $id);

        if ($data == FALSE)
        {
            //$greska = validation_errors();    
            echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-danger">'.validation_errors().'</div>'));
            
        }
        else
        {     
            if($id)
            {
                $polje = $this->getFieldId($table);
                //azuriranje
                $this->registracija_model->update($table, $polje, $id, $data);      
                
                echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no a&#382;uriran '.$table.'!</div>', 'id' => $id, 'email' => $data['op_mail']));
                //$this->session->set_flashdata('edit_successful', true);
            }   
            else
            {   
                //spremjanje
                $id = $this->registracija_model->create($table, $data);
                   
                //$this->session->set_flashdata('add_successful', true);
                echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no spremljen '.$table.'!</div>', 'id' => $id));    
            } 
        }       
    }
    
     private function getFieldId($table) {
        switch ($table) {
            case 'operater':
                $id = 'op_id';
                break;
           
            case 'firma':
                $id = 'fi_id';
                break;
            default:
                $id = 'id';
                break;
        }

        return $id;
    }
    
    
    
    public function resetPass()
    {
        $email = $this->input->post('mail');
        
        
        //provjeri da li mail postoji u bazi ako da resetiraj random pass 
        
        //spremi novi pass u bazu
        
        //posalji pass na email korisniku
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('mail', 'Email', 'trim|required|xss_clean|valid_email');
        
        if ($this->form_validation->run()) {

            $this->load->model('korisnik');          

            //korisnik koji se logira a op_code mu je prazan tj NULL
            if ($this->korisnik->getNumRows('operater', 'op_mail', $email) == 1) {
                
                //resetiraj pass
                $noviPass = $this->rand_passwd();
                
                $data['op_lozinka']  = sha1($noviPass);
                
                $this->korisnik->update('operater', 'op_mail', $email, $data); 
                
                //pošalji na email korisniku
                $ime = 'Mobilni ured';
                $from = 'noreplay@mobilniured.com';
                $to         = $email;
                $subject     = 'Nova lozinka MobilniUred.com';
                $message     = "Poštovani, <br />Vaša nova lozinka je: <b> $noviPass</b>  <br />Ukoliko niste zatražili resetiranje lozinke zanemarite ovaj email.<br/>
                                Lijep pozdrav, <br/>Mobilni Ured Tim";    

                if($this->my_model->send_email($to, $from, $ime, $subject, $message)){
                    echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Nova lozinka poslana Vam je na mail.</div>'));           

                }else{ 
                    echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-danger">Dogodila se gre&#353;ka poku&#353;ajte ponovno !</div>')); 
                              
                } //Kraj if poslano     
                
                        
 
                //redirect(base_url().'pocetna');
                
            } 
            else
            {
                echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-danger">Nepostoji korisnik s ovom email adresom! Registrirajte se.</div>'));        
            }
        } else {
            echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-danger">'.validation_errors().'</div>'));      
        }   
    } 
    
    
    function rand_passwd( $length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789' ) 
    {
        return substr( str_shuffle( $chars ), 0, $length );
    }  
    
  }
?>
