<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
  
  
  class Administracija extends MY_Controller
  {
      public function __construct()
      {
        parent::__construct();
        $this->load->model('admin'); 
        $this->load->model('dokumenti');
        $this->load->library('upload'); 
        $this->load->model('pocetna_model'); 
        $this->load->language('custom');      
      }

    /**
     * Shows the admin dashboard page
     * 
     * This is the default action for admin Dashboard controller. This function shows the admin dashboard page.
     */
    public function index()
    {
        $nezavrseni = $this->pocetna_model->getDokumentNedovrsen('racun');
        $neplaceni = $this->pocetna_model->getDokumentNeplacen('racun');
        $ponudeOtvorene = $this->pocetna_model->getPonudeOtvorene('ponuda');
        $brojNefiskaliziranihRacuna = $this->pocetna_model->getNefiskalizirane();
        $vrstedokumenta =  $this->pocetna_model->getVrsteDokumenta(); 
        $statistike =  $this->pocetna_model->getStatistike();
        $najprodavanijiArtikli =  $this->pocetna_model->chartNajprodavanijiArtikli(); 
        $sumePoDanima =  $this->pocetna_model->charSumePoDanu();    
      
       
        $data = array(
        'nezavrseni' => $nezavrseni,
        'neplaceni' => $neplaceni,
        'ponudeOtvorene' => $ponudeOtvorene,
        'nefiskalizirani' => $brojNefiskaliziranihRacuna,
        'vrstedokumenta'  => $vrstedokumenta,
        'statistike'      => $statistike,
        'najprodavanijiArtikli' => $najprodavanijiArtikli,
        'sumePoDanima' => $sumePoDanima           

        );
        
        $this->load->view('pocetna', $data);       
    }  
    
    public function info()
    {
         $this->load->view('info/info');              
    } 
    
    public function profil()
    {
         $this->load->view('profil/profil');              
    }      
    
    
    public function pregled($table) {
        //vrsta dokumenta ID
        $id = $this->input->post('id');
        $data = $this->getVars($table, $id);
        $this->load->view('sifarnici/'.$table.'/pregled', $data);
    
 
    }  
    
    
    public function korisnici() {
        
        $korisnici = $this->admin->getKorisnici();

        $data = array(
            'table'     =>  $korisnici
        );
                
        $this->load->view('pregled/pregled_korisnika', $data);
    
 
    }
    
    public function uredjivanje($table) {
        
        $id = $this->input->post('id');
        $fieldId = $this->getFieldId($table);
        $object  = $this->admin->getById($table, $fieldId, $id);

        $data = $this->getVars($table, $id);
        $data['object']     = $object;
        $data['id']   = $id;
        $data['tablica']    = $table;

        $this->load->view('sifarnici/'.$table.'/uredi', $data);          
    }
    
    
    public function process_form($table)
    {
        $id = $this->input->post('id');
        
        //Set some validation rules
                       
        $data = $this->admin->post_validacija($table, $id);

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
                $this->admin->update($table, $polje, $id, $data);      
                
                echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no a&#382;uriran '.$table.'!</div>'));
                //$this->session->set_flashdata('edit_successful', true);
            }   
            else
            {
                //spremjanje
                $this->admin->create($table, $data);
                   
                //$this->session->set_flashdata('add_successful', true);
                echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no spremljen '.$table.'!</div>'));    
            } 
        }       
    }
    
    
    
    public function dodaj($table) { 
     
        $data = $this->getVars($table);
        $data['tablica'] = $table;
        $this->load->view('sifarnici/'.$table.'/uredi', $data);
    }
    
    
    private function getFieldId($table) {
        switch ($table) {
            case 'operater':
                $id = 'op_id';
                break;
            case 'partner':
                $id = 'pa_id';
                break;
            case 'artikl':
                $id = 'ar_id';
                break;            
            case 'dokument':
                $id = 'do_id';
                break; 
            case 'naplatniuredjaj':
                $id = 'nu_id';
                break;
            case 'prodajnomjesto':
                $id = 'pm_id';
                break;            
            case 'stavkedokumenta':
                $id = 'sd_id';
                break;
            default:
                $id = 'id';
                break;
        }

        return $id;
    }
    
    
    
    private function getVars($table, $id = null) {

        switch ($table) {
            case 'operater':
                $tablica = $this->admin->getOperater();
                $data = array(
                    'table'     =>  $tablica
                );
                break;
            case 'partner':
                $tablica = $this->admin->getPartner();
                $data = array(
                    'table'     =>  $tablica
                );
                break;
            case 'artikl':
                $tablica = $this->admin->getArtikl();
                //$porezi = $this->admin->getFromTable('porez');
                $porezi = $this->admin->getPorezneStope();
                $mjere = $this->admin->getMjere();
                $data = array(
                    'table'     =>  $tablica,
                    'porezi'    =>  $porezi,
                    'mjere'     =>  $mjere
                );
                break; 
            case 'dokument':
                $id = $this->input->post('id');
                $tablica = $this->admin->getDokument($id);
                $vrstaDok = $this->admin->vrstaDokumenta($id);
                $data = array(
                    'table'             =>  $tablica,
                    'vrstaDokumenta'    =>  $vrstaDok
                );
                break;
            default:
                $tablica = $this->admin->getFromTable($table);
                $data['table'] = $tablica;
                break;
        }

        return $data;
    }
    
    public function vrati($table)
    { 
        $data = $this->getVars($table);
        $this->load->view('sifarnici/'.$table.'/pregled', $data); 
    }
    
    
    public function brisanje($table) {
        $fieldId = $this->getFieldId($table);
        $id = $this->input->post('id');
        $idzag = $this->input->post('idzag');
        
        $ok = TRUE;
        switch ($table) {
            case 'operater':
                if ($this->admin->getNumRows('operater', 'op_id', $id) > 0) {
                    $ok = FALSE;
                    $msg = '<div class="alert alert-warning">'.$table.' se ne brise, nego stavi neaktivan!!</div>';
                }
                break; 
            case 'artikl':
                if ($this->admin->getNumRows('stavkedokumenta', 'Artikl_ar_id', $id) > 0) {
                    $ok = FALSE;
                    $msg = '<div class="alert alert-warning">'.$table.' se koristi u dokumentima!!</div>';
                }
                break; 
                
            case 'dokument':
                if ($this->admin->getNumRows('stavkedokumenta', 'dokument_do_id', $id) > 0) {
                    //brisi stavke dokumenta pa zaglavlje
                    $this->admin->delete('stavkedokumenta', 'dokument_do_id', $id);
                    $ok = TRUE;
                }
                break;
            case 'partner':
                if ($this->admin->getNumRows('dokument', 'Partner_pa_id', $id) > 0) {
                    $ok = FALSE;
                    $msg = '<div class="alert alert-warning">'.$table.' ima napravljenih dokumenata!!</div>';
                }
                break;
            case 'naplatniuredjaj':
                if ($this->admin->getNumRows('dokument', 'naplatniuredjaj_nu_id', $id) > 0) {
                    $ok = FALSE;
                    $msg = '<div class="alert alert-warning">'.$table.' ima napravljenih dokumenata!!</div>';
                }
                break;
            case 'prodajnomjesto':   
                if ($this->dokumenti->getPP($id) > 0) {  
                
                    //provjeri da li je poslovni prostor prijavljen i otvoren tada ne dozvoli brisanje          
                    $ok = FALSE;
                    $msg = '<div class="alert alert-warning">Poslovni prostor je otvoren!!</div>';           
                }
                else  if ($this->admin->getNumRows('naplatniuredjaj', 'prodajnoMjesto_pm_id', $id) > 0) {  
                    $ok = FALSE;
                    $msg = '<div class="alert alert-warning">'.$table.' ima dodan naplatni ure&#273;aj !!</div>';
                }
                break;
        }


        if ($ok) {
            if ($this->admin->delete($table, $fieldId, $id)) {
                echo json_encode(array('poruka' => '<div class="alert alert-success">'.$table.' uspje&#353;no obrisan!</div>'));
                
                 // update zaglavlja
                if($idzag)
                {
                    $dok['do_iznosPDV'] = $this->dokumenti->suma_porez($idzag);
                    $dok['do_iznos'] = $this->dokumenti->suma_iznos($idzag);
                    $this->dokumenti->update("dokument", "do_id", $idzag, $dok);
                }
      
            } else {
                echo json_encode(array('poruka' => '<div class="alert alert-danger">Dogodila se gre&#353;ka pri brisanju!!</div>'));
            }
        } else {
            echo json_encode(array('poruka' => $msg));
        }
    }
    
    
      public function change_password() {
        $id = $this->input->post('id'); 
        $this->load->library('form_validation');

         $this->form_validation->set_rules('password', 'Lozinka', 'required|min_length[6]|max_length[30]|matches[confirmPassword]|xss_clean');
         $this->form_validation->set_rules('confirmPassword', 'Lozinka potvrde', 'required|min_length[6]|max_length[30]|xss_clean'); 

        if ($this->form_validation->run()) {
            
            if ($this->admin->updatePassword($id, sha1($this->input->post('confirmPassword')))) {
        
                echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no a&#382;urirana lozinka!</div>'));
                
            } else {
                
                echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-warning">Neuspje&#353;no editirana lozinka!</div>'));
            }
        } else {
            echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-warning">Neuspje&#353;no editirana lozinkaaaa!</div>'));

        }
      
    }      
    
           
  }
?>
