<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stranica extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');  
        $this->load->model('registracija_model');       
    }
    

    public function index()
    {      
        //ako je korisnik ulogiran redirect na poèetnu
        if ($this->session->userdata('is_logged_in') == 1) {
            redirect('pocetna');
        }
        else
        //ukoliko se radi lokalno koristiti prvu liniju koda, ukoliko je na serveru za redirect koristi drugu liniju
        {   
            $this->load->view('index');    
            //header('Location: http://mobilniured.com');  
        }
    }   
    
    
    public function logout()
    {   
        $this->session->sess_destroy();
        redirect(base_url());
         
    } 
    
    
    public function login()
    {    
        //redirect('pocetna');
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

        if ($this->form_validation->run()) {

            $this->load->model('korisnik');

            $email         = $this->input->post('email');
            $password    = $this->input->post('password');

            //korisnik koji se logira a op_code mu je prazan tj NULL
            if ($this->korisnik->getNumRows('operater', 'op_mail', $email, 'op_lozinka', sha1($password), 'op_code') == 1) {
                
                $this->korisnik->login($email, sha1($password));
                 
                echo json_encode(array('uspjelo'=>'1', 'url' => base_url().'pocetna'));  

                //redirect(base_url().'pocetna');
                
            //ako ima op_code znaèi da je zapoèeo registraciju pa ga redirectaj na registracija / token / op_code
            //kada se pokuša ulogirati na login formi
            } else if($this->korisnik->getNumRows('operater', 'op_mail', $email, 'op_lozinka', sha1($password)) == 1) {
                $korisnik = $this->korisnik->getById('operater', 'op_mail', $email, 'op_lozinka', sha1($password));  
                
                //redirect(base_url().'registracija/token/'.$korisnik->op_code);
                echo json_encode(array('uspjelo'=>'1', 'url' => base_url().'registracija/token/'.$korisnik->op_code));  


            }
            //korisnik ne postoji ni kao registiran niti meðu onima koji su zapoèeli registraciju
            else
            {
                //$this->session->set_flashdata('login_error', 'PogreÅ¡no ste unijeli podatke za prijavu, pokuÅ¡ajte ponovno. ');
                echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-danger">Pogre&#353;no ste unijeli podatke za prijavu, poku&#353;ajte ponovno !</div>'));  
                //redirect(base_url()); 
            }
        } else {
            //$this->session->set_flashdata('login_error', validation_errors());      
            ///$this->session->set_flashdata('login_error', 'PogreÅ¡no ste unijeli podatke za prijavu, pokuÅ¡ajte ponovno. ');
            echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-danger">Pogre&#353;no ste unijeli podatke za prijavu, poku&#353;ajte ponovno !</div>')); 
 
            //redirect(base_url());
        }   
    }  
    
    public function login_nakon_registracije(){    
        //redirect('pocetna');
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

        if ($this->form_validation->run()) {

            $this->load->model('korisnik');

            $email         = $this->input->post('email');
            $password    = $this->input->post('password');

            //korisnik koji se logira a op_code mu je prazan tj NULL
            if ($this->korisnik->getNumRows('operater', 'op_mail', $email, 'op_lozinka', $password, 'op_code') == 1) {
                
                $this->korisnik->login($email, $password);
                
                redirect(base_url().'pocetna');
                
            //ako ima op_code znaèi da je zapoèeo registraciju pa ga redirectaj na registracija / token / op_code
            //kada se pokuša ulogirati na login formi
            } else if($this->korisnik->getNumRows('operater', 'op_mail', $email, 'op_lozinka', $password) == 1) {
                $korisnik = $this->korisnik->getById('operater', 'op_mail', $email, 'op_lozinka', $password);  
                
                redirect(base_url().'registracija/token/'.$korisnik->op_code);
                

            }
            //korisnik ne postoji ni kao registiran niti meðu onima koji su zapoèeli registraciju
            else
            {   
                $this->session->set_flashdata('login_error', 'PogreÅ¡no ste unijeli podatke za prijavu, pokuÅ¡ajte ponovno.');
                redirect(base_url()); 
            }
        } else {
            $this->session->set_flashdata('login_error', validation_errors());
            //$this->session->set_flashdata('login_error', validation_errors());
            redirect(base_url());
        }   
    } 
    
    
    public function register()
    {    
        //redirect('pocetna');
        
        $data = $this->registracija_model->post_validacija('operater', $id = NULL);

        if ($data == FALSE)
        {
            //$greska = validation_errors();    
            echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-danger">'.validation_errors().'</div>'));        
        }
        else
        {
     
            $code  = md5(uniqid(rand()));
            $ime = $this->input->post('ime');
            $email = $this->input->post('email');
            $link  = base_url().'registracija/token/'.$code;
             
            $data = array(  
                        'op_ime'            => $ime,
                        'op_prezime'        => $this->input->post('prezime'),
                        'op_mail'           => $email,
                        'op_lozinka'        => sha1($this->input->post('confirmPassword')),
                        'op_code'           => $code
                        );
          
           //spremjanje
                        
            if ($this->registracija_model->create('operater', $data)) 
            {     
                $to         = $email;
                $name       = 'Mobilni ured';
                $from       = 'noreplay@mobilniured.com';   
                $subject    = 'Registracija MobilniUred.com';
                $message    = "Poštovani $ime, <br />kliknite na link kako biste nastavili s registracijom $link <br />Ukoliko niste zatražili registraciju zanemarite ovaj email.<br/>
                                Lijep pozdrav, <br/>Mobilni Ured Tim.";

                if($this->my_model->send_email($to, $from, $name, $subject, $message)){
                    echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no ste se prijavili. Provjerite svoj email radi nastavka registracije !</div>'));           

                }else{ 
                    echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-danger">Dogodila se gre&#353;ka poku&#353;ajte ponovno !</div>')); 
                              
                } //Kraj if poslano
                     
            } else {
                 echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-danger">Dogodila se gre&#353;ka poku&#353;ajte ponovno !</div>'));     
                //$this->session->set_flashdata('register_error', 'PogreÅ¡no ste unijeli podatke za registraciju, pokuÅ¡ajte ponovno. ');
                
            }     
          
        }       

    }

}
  
?>
