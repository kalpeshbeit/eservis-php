<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
  
  
  class Dokument extends MY_Controller
  {
      public function __construct()
      {
        parent::__construct();
        $this->load->model('dokumenti');     
        $this->load->model('admin');     
      }

    /**
     * Shows the admin dashboard page
     * 
     * This is the default action for admin Dashboard controller. This function shows the admin dashboard page.
     */
    public function index()
    {
        $this->load->view('pocetna');       
    }  
    
    
    public function uredjivanje($table) {
        //ovaj ID je od dokumenta
        $id = $this->input->post('id');        
        $fieldId = $this->getFieldId($table);
        $object  = $this->dokumenti->getDokumentZag($id);  
        
        $data = $this->getVars($table, $id, $object->do_status); 
        
        
        $tablica = $this->dokumenti->getDokumentZag($id); 
        $data['object']     = $object;
        $data['table']     = $tablica;
        $data['id']   = $id;    
        $data['status']   = $object->do_status;    

        //pokupi ID vrste dokumenta da se pokupi vd_oznaka za load view
        $vrstaDok = $this->dokumenti->vrstaDokumenta($object->vrstadokumenta_vd_id); 
        
        
        
        $data['idvrstedokumenta'] = $vrstaDok;
        
        $this->load->view('sifarnici/'.$table.'/uredi/'.$vrstaDok->vd_oznaka, $data);          
    }
    
    
    public function process_form($table)
    {
        $id = $this->input->post('id');
        $idVrsteDok = $this->input->post('id_vrsteDokumenta'); 
        //Set some validation rules
        $data = $this->dokumenti->post_validacija($table, $id);

        if ($data == FALSE)
        {
            //$greska = validation_errors();
            echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-danger">Neuspje&#353;no editirano!</div>'));
        }
        else
        {     
            if($id)
            {
                $polje = $this->getFieldId($table);
                //azuriranje
                $data['do_status'] = "Z";
                $this->dokumenti->update($table, $polje, $id, $data);
                
                echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no a&#382;uriran '.$table.'!</div>'));
                //$this->session->set_flashdata('edit_successful', true);
            }   
            else
            {
                //spremjanje  
                $broj = $this->dokumenti->dohvatiBrojDokumenta($idVrsteDok);              
                $data['do_broj'] =   $broj->broj;
                $data['do_status'] = "Z";
                $id = $this->dokumenti->create($table, $data);
                
                //azuriraj seriju
                $podatak['se_broj'] = $broj->broj; 
                $this->dokumenti->update('serije', 'se_id', $broj->ID, $podatak);
                
                //$this->session->set_flashdata('add_successful', true);
                echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no spremljen '.$table.'!</div>','IDzag'=>$id));
            } 
        }       
    }
    
    
    
    public function process_form_racun($table)
    {
        $id = $this->input->post('id');
        $idVrsteDok = $this->input->post('id_vrsteDokumenta'); 
        $idNU = $this->input->post('naplatni_uredjaj'); 
        $idPP = $this->input->post('poslovni_prostor'); 
        //Set some validation rules
        $data = $this->dokumenti->post_validacija($table, $id);

        if ($data == FALSE)
        {
            //$greska = validation_errors();
            echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="bg-danger">Neuspje&#353;no editirano!</div>'));
        }
        else
        {     
            if($id)
            {
                $polje = $this->getFieldId($table);
                //azuriranje
                $this->dokumenti->update($table, $polje, $id, $data);
                
                echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no a&#382;uriran '.$table.'!</div>'));
                //$this->session->set_flashdata('edit_successful', true);
            }   
            else
            {
                //spremjanje  
                $broj = $this->dokumenti->dohvatiBrojDokumentaRacun($idVrsteDok, $idNU, $idPP);              
                //$data['do_broj'] =   $broj->broj;
                $data['do_datum'] = date('Y-m-d');  
                $data['do_vrijeme'] = date('H:i');  
                $data['pg_godina'] = date('Y');
                
                $id = $this->dokumenti->create($table, $data);
                
                //$this->session->set_flashdata('add_successful', true);
                echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no spremljen '.$table.'!</div>','IDzag'=>$id));
            } 
        }       
    }
    
    public function azurirajSeriju()
    {
        $idVrsteDok = $this->input->post('id');
        $idNU = $this->input->post('idNU');
        $idPP = $this->input->post('idPP');
        
        $id = $this->input->post('iddok');
          //azuriraj seriju
        $broj = $this->dokumenti->dohvatiBrojDokumentaRacun($idVrsteDok, $idNU, $idPP);              
          
        $podatak['se_broj'] = $broj->broj; 
        $this->dokumenti->update('serije', 'se_id', $broj->ID, $podatak);
        
        
        //update dokument zag 
        $data['do_broj'] = $broj->broj; 
        $data['do_status'] = "Z"; 
        $this->dokumenti->update('dokument', 'do_id', $id, $data);
    }
    
    public function process_form_stavka($table)
    {
        //id zaglavlja
        $id = $this->input->post('idzag');
    
        $idstavka = $this->input->post('id_odabrana_stavka');  
        
        //Set some validation rules
        $data = $this->dokumenti->post_validacija($table, $idstavka);

        if ($data == FALSE)
        {
            //$greska = validation_errors();
            echo json_encode(array('uspjelo'=>'0', 'poruka' =>  '<div class="alert alert-danger">Neuspje&#353;no editirano!</div>'));
        }
        else
        {    
            $polje = $this->getFieldId($table); 
            
            //ako postoji id zaglavlja spremi stavku
            if($id)
            {
                //ako postoji id stavke update
                if($idstavka == "novastavka")
                {
                    //insert stavke za to zaglavlje
                    $this->dokumenti->create($table, $data);

                    //$this->session->set_flashdata('add_successful', true);
                     echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no spremljen '.$table.'!</div>'));
                    
                }
                else
                {
                    //azuriranje
                    $this->dokumenti->update($table, $polje, $idstavka, $data);
                
                    echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no a&#382;uriran '.$table.'!</div>'));

                }

            }   
            else
            {                
                $this->dokumenti->create($table, $data);

                //$this->session->set_flashdata('add_successful', true);
                echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no spremljen '.$table.'!</div>'));
            } 
            
            
            //update zaglavlja
            
            $dok['do_iznosPDV'] = $this->dokumenti->suma_porez($id);
            $dok['do_iznos'] = $this->dokumenti->suma_iznos($id);
            
            $this->dokumenti->update("dokument", "do_id", $id, $dok); 
        }       
    }
    
    
    public function dodaj($table) { 
    
        $id = $this->input->post('id');

    
        $data = $this->getVars($table);
        $data['tablica'] = $table;
        $vrstaDok = $this->dokumenti->vrstaDokumenta($id); 
        $data['idvrstedokumenta'] = $vrstaDok; 
        $data['status']   = "I"; 
        //ako je opis vrste dok racun onda uzmi prvi id prodajnog mjesta i prvi id naplatnog uredjaja i izracunaj broj dok
        
        if($vrstaDok->vd_oznaka == "racun")
        {
             //$data['broj_dokumenta'] = $this->dokumenti->dohvatiBrojDokumenta($id);
        }
        else
        {
            //izraèunati broj dokumenta ovisno o vrsti,  prodajnom mjestu, poslovnoj godini
            $data['broj_dokumenta'] = $this->dokumenti->dohvatiBrojDokumenta($id); 
        }
        $this->load->view('sifarnici/'.$table.'/uredi/'.$vrstaDok->vd_oznaka, $data);
    } 
    
    
    public function racunizponude() { 
        
        //id racuna koji se kopira
        $id = $this->input->post('id');
        //dupliraj zaglavlje i stavke
        
        //id novog dokumenta
        $idNovog = $this->dokumenti->racunizponudeZag($id);
         
        $this->dokumenti->racunizponudeStavke($id, $idNovog); 
        
        echo json_encode(array('uspjelo'=>'1', 'id' => $idNovog));
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
            case 'stavkedokumenta':
                $id = 'sd_id';
                break; 
            case 'naplatniuredjaj':
                $id = 'nu_id';
                break;
            case 'prodajnomjesto':
                $id = 'pm_id';
                break;
            default:
                $id = 'id';
                break;
        }

        return $id;
    }
    
    
    
    private function getVars($table, $id = null, $status = null) {

        switch ($table) { 
            case 'dokument':
 
                $partner =    $this->dokumenti->getPartner(); 
                
                if($id && $status != "I")
                {
                     $prodajnomjesto = $this->dokumenti->getProdajnaMjestaSva();
                }
                else
                {
                    $prodajnomjesto = $this->dokumenti->getProdajnaMjesta();
                }
           
                $vrstaplacanja = $this->dokumenti->getSredstvoPlacanja(); 
                
                if(!$prodajnomjesto)
                {
                    $nemaprodajnogmjesta = 1;
                }
                else
                {
                    $nemaprodajnogmjesta = 0;
                }
                
                $data = array(
                    'partneri'          => $partner,
                    'prodajnamjesta'          => $prodajnomjesto,
                    'sredstvoplacanja' =>   $vrstaplacanja,
                    'nemaprodajnogmjesta' => $nemaprodajnogmjesta
                );
                break;
            default:
                $tablica = $this->dokumenti->getFromTable($table);
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
                    $msg = '<div  class="alert alert-warning">'.$table.' se koristi u dokumentima!!</div>';
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
                    $msg = '<div  class="alert alert-warning">'.$table.' ima napravljenih dokumenata!!</div>';
                }
                break;
            case 'prodajnomjesto':
                if ($this->admin->getNumRows('naplatniuredjaj', 'prodajnoMjesto_pm_id', $id) > 0) {
                    $ok = FALSE;
                    $msg = '<div  class="alert alert-warning">'.$table.' ima dodan naplatni ure&#273;aj !!</div>';
                }
                break;
        }


        if ($ok) {
            if ($this->admin->delete($table, $fieldId, $id)) {
                echo json_encode(array('poruka' => '<div class="alert alert-success">'.$table.' uspje&#353;no obrisan!</div>'));
                
            } else {
                echo json_encode(array('poruka' => '<div class="alert alert-danger">Dogodila se gre&#353;ka pri brisanju!!</div>'));

            }
        } else {
            echo json_encode(array('poruka' => $msg));
        }
    }
    
    
    public function prikaziStavke() {      
        //loadaj i sve artikle, porezne stope,  jedinice mjere    
        $id = $this->input->post('id');
          
        $stavka = $this->dokumenti->getstavke($id);  
        $porezi = $this->dokumenti->getPorezneStope();
        $mjere = $this->admin->getMjere();   
        $artikli = $this->dokumenti->getArtikl(); 
        $sume =  $this->dokumenti->sume($id);
            
        $data = array(
            'stavke' => $stavka,
            'idZaglavlja' => $id,
            'artikli' => $artikli,
            'mjere' => $mjere,
            'porezi' => $porezi
        );  
        
        $data['sume']     = $sume;        
        $this->load->view('sifarnici/dokument/ajax/stavkePonuda', $data);
              
    }    
    
    
    public function dodajStavku() {      
         
         //ovo je id stavke   
        $id = $this->input->post('id');
        $idzag = $this->input->post('idzag');
        //$object  = $this->admin->getById("stavkedokumenta", "sd_id", $id);  
        $object  = $this->dokumenti->getstavka($id);
        $stavka = $this->dokumenti->getstavke($idzag);  
        $porezi = $this->dokumenti->getPorezneStope();
        $mjere = $this->admin->getMjere();   
        $artikli = $this->dokumenti->getArtikl();     
            
        $data = array(
            'stavke' => $stavka,
            'id' => $id,
            'artikli' => $artikli,
            'mjere' => $mjere,
            'porezi' => $porezi
        );     
        
         $data['object']     = $object;
            
        $this->load->view('sifarnici/dokument/ajax/stavkePonudaUredjivanje', $data);
              
    }     
    
    
    
    
    public function prikaziNaplatniUredjaj() {      
            
        $id = $this->input->post('id');
         
         if($id)
         {
             $uredjaj = $this->dokumenti->getNaplatniUredjaj($id);  
        
            if(count($uredjaj) > 0 )
            {
                foreach ($uredjaj as $item){
                    echo '<option  value="' .$item->nu_id.'" >' .$item->nu_broj.' </option>';                                                                                                 
                }
            }
            else
            {
                echo '<option value="" placeholder=""></option>';     
            }       
         } 
         else
         {
               //$this->session->set_flashdata('nema_naplatnog', true);
         }
       
    }        
    
    
    
    public function dohvatiSredstvoPlacanja() {      
            
        $id = $this->input->post('id');
         
         if($id)
         {
            echo json_encode($this->dokumenti->getSredPlacanja($id));  
         }        
    }       
    
    
    
    public function dohvaticijenuPDVJmj($table) {      
            
        $id = $this->input->post('id');
        
        $fieldId = $this->getFieldId($table);
        
        echo json_encode($this->dokumenti->getArtiklPodaci($id));
        
    }    
    
    
    
    public function getPorezneStopeSifra() {      
            
        $posto = $this->input->post('posto');
        
        echo json_encode($this->dokumenti->getPorezneStopeSifra($posto));
        
    }
    
    public function prikaziizvjestaj()
    {      
        $data = array(
            'id' => $this->input->post('id'),
            'idvrstaDok' => $this->input->post('idvrstaDok'),
            'vrstaDok' => $this->dokumenti->vrstaDokumenta($this->input->post('idvrstaDok'))         
            );  
            
        //pozovi view report
        $this->load->view('sifarnici/dokument/ajax/report', $data);
    } 
    
    
    public function storniraj()
    { 
        //id dokumenta     
        $id = $this->input->post('id');
        $zaglavlje = $this->dokumenti->getById('dokument','do_id', $id);  
        
        //trenutni dokument   stavi oznaku S - storno
       
        //$data['do_status'] = "S";
        //pozovi storno
        //$storno = $this->dokumenti->update("dokument", "do_id", $id, $data);
        
        
        //ako nema vezanog dokumenta znaci nije storniran
        
        if(!$zaglavlje->do_id_vezanog && $zaglavlje->do_status != "S" ) 
        {         
            // napravi novi dokument isti kao ovaj kojeg storniraš
            // stavi mu oznaku storno i svake u minus te ID vezanog dokumenta ovaj poslani $id
            
               //$.post("<?php echo site_url().'dokument/process_form_racun/dokument'; 
               //$.post("<?php echo site_url().'dokument/azurirajSeriju'; ",{iddok: iddok,id: id, idNU: idNU, idPP: idPP}, function(data) { });
            
            //kopirati zaglavlje dokumenta kojeg storniraš
                                    
            $data = array(
                'firma_fi_id'             => $this->session->userdata('firmaID'),    
                'do_datum'                => date('Y-m-d'),  
                'do_vrijeme'              => date('H:i'),
                'do_valuta'               => date('Y-m-d', strtotime($zaglavlje->do_valuta)),     
                'do_dvo'                  => date('Y-m-d', strtotime($zaglavlje->do_dvo)),                
                'operater_op_id'          => $zaglavlje->operater_op_id,
                'sredstvoplacanja_sp_id'  => $zaglavlje->sredstvoplacanja_sp_id, 
                'vrstadokumenta_vd_id'    => $zaglavlje->vrstadokumenta_vd_id,
                'prodajnoMjesto_pm_id'    => $zaglavlje->prodajnoMjesto_pm_id,
                'naplatniuredjaj_nu_id'   => $zaglavlje->naplatniuredjaj_nu_id,
                'Partner_pa_id'           => $zaglavlje->Partner_pa_id ,
                'pa_naziv'                => $zaglavlje->pa_naziv,
                'do_osoba'                => $zaglavlje->do_osoba,
                'do_napomena'             => $zaglavlje->do_napomena,
                'do_status'               => 'S',
                'pg_godina'               => date('Y'),
                'do_mjestoizdavanja'      => $zaglavlje->do_mjestoizdavanja,
                'pa_adresa'               => $zaglavlje->pa_adresa,
                'pa_mjesto'               => $zaglavlje->pa_mjesto,
                'pa_posta'                => $zaglavlje->pa_posta,
                'pa_oib'                  => $zaglavlje->pa_oib,
                'do_iznos'                => '-'.$zaglavlje->do_iznos,
                'do_iznosPDV'             => '-'.$zaglavlje->do_iznosPDV,
                'do_placeno'              => $zaglavlje->do_placeno
            );
       
            //spremanje   
            $broj = $this->dokumenti->dohvatiBrojDokumentaRacun($zaglavlje->vrstadokumenta_vd_id, $zaglavlje->naplatniuredjaj_nu_id, $zaglavlje->prodajnoMjesto_pm_id);
                          
            $data['do_broj'] =   $broj->broj;
              
            $idnovog = $this->dokumenti->create('dokument', $data);
            
            $stavke = $this->dokumenti->getstavke($id);  
            
            foreach ($stavke as $stav)
            {
                $podacistavke = array(
                    'dokument_do_id'          =>  $idnovog,    
                    'porez_pz_posto'          =>  $stav->porez_pz_posto, 
                    'poreznastopa_pz_sifra'   =>  $stav->poreznastopa_pz_sifra,   
                    'JedinicaMjere_jm_sifra'  =>  $stav->JedinicaMjere_jm_sifra,               
                    'sd_kolicina'             =>  '-'.$stav->sd_kolicina,              
                    'sd_cijenabruto'          =>  $stav->sd_cijenabruto,               
                    'sd_popust'               =>  $stav->sd_popust,               
                    'Artikl_ar_id'            =>  $stav->Artikl_ar_id,
                    'ar_naziv'                =>  $stav->ar_naziv,
                    'sd_iznospopusta'         =>  '-'.$stav->sd_iznospopusta,
                    'sd_cijenaneto'           =>  $stav->sd_cijenaneto, 
                    'sd_iznosneto'            =>  '-'.$stav->sd_iznosneto,
                    'sd_poreziznos'           =>  '-'.$stav->sd_poreziznos,
                    'ar_dodatniopis'          =>  $stav->ar_dodatniopis,
                    'operater_op_id'          =>  $this->session->userdata('id_osoba')
                );   
            
                $this->dokumenti->create('stavkedokumenta', $podacistavke);     
            }    
            
            //iskopiraj stavke dokumenta

            //azuriraj seriju
            $podatak['se_broj'] = $broj->broj; 
            $this->dokumenti->update('serije', 'se_id', $broj->ID, $podatak);
            
            $zag['do_id_vezanog'] = $idnovog;
            //povezi zaglavlje storniranog sa storno dokumentom preko ID.a storna
            $this->dokumenti->update('dokument', 'do_id', $id, $zag);
                             
                      
    
            // pošalji ga na fiskalizaciju
             //$.post("<?php echo site_url().'fiskalizacija/fiskal'; ",{request: "RacunZahtjev", id: iddok}, function(data) { 
        
        
            echo json_encode(array('poruka' => '<div class="alert alert-success">Dokument uspje&#353;no storniran!</div>', 'sp_id' => $zaglavlje->sredstvoplacanja_sp_id, 'vd_id' => $zaglavlje->vrstadokumenta_vd_id, 'id_novog' => $idnovog)); 
        }
        else if($zaglavlje->do_status != "S")
        {
            $brojstornodokumenta = $this->dokumenti->getDokumentZag($zaglavlje->do_id_vezanog);
            echo json_encode(array('poruka' => '<div class="alert alert-info">Dokument je vec storniran dokumentom broj '.$brojstornodokumenta->do_broj.'/'.$brojstornodokumenta->PP.'/'.$brojstornodokumenta->NU.'!</div>', 'status' => '0'));
        }
        else
        {
              echo json_encode(array('poruka' => '<div class="alert alert-info">Ovo je storno dokumenta!</div>', 'status' => '0')); 
        }

        
    }
    
    
    
    
    public function pdf($id, $idvrstaDok, $opis){
     //$id = $this->input->post('id');
        ob_start();
            
        $fiID =  $this->session->userdata('firmaID');
        $broj =   $this->dokumenti->getById("dokument", "do_id", $id);  
         
        $firma =  $this->dokumenti->getById("firma", "fi_id", $fiID);
        $data = array();
        $data = array(
            'prikaziStavke' => $this->dokumenti->getstavke($id) ,
            'zaglavlje' => $this->dokumenti->getDokumentZag($id) ,
            'vrstaDokumenta' => $this->dokumenti->vrstaDokumenta($idvrstaDok),
            'rekapitualcijaporeza' => $this->dokumenti->rekapitulacijaporeza($id)
            ); 
         
         
        $data['firma'] = $firma; 
          
        if($broj->Partner_pa_id)
        {
         $data['partner'] = $this->dokumenti->getById("partner", "pa_id", $broj->Partner_pa_id);
        } 
          
        $data['sume'] = $this->dokumenti->sume($id);             
        
        if($opis =="ponuda")
        {
            $html = $this->load->view('sifarnici/dokument/PDF/pdf_ponuda', $data, true);  
        }
        else
        {
            if($this->session->userdata('UsustavuPDV') == 1)
            {
                $html = $this->load->view('sifarnici/dokument/PDF/pdf_racunPDV', $data, true);   
            }
            else
            {
                $html = $this->load->view('sifarnici/dokument/PDF/pdf_racun', $data, true);   
            }
        }
        

        // render the view into HTML
        //$html = 'asdasd asd asd as a ';
        $this->load->library('mpdf');
        $mpdf = new mPDF('utf-8','A4');

        $mpdf->SetHTMLFooter('
        <table width="100%" style="border-top: 1px solid; vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000;"><tr>
        <td width="10%"></span></td>
        <td width="80%" align="center" style="font-style: italic;">'. $firma->fi_opis.'</td>
        <td width="10%" style="text-align: right;  ">{PAGENO}/{nbpg}</td>
        </tr></table>
        ');

        $mpdf->setHeader('{DATE d.m.Y H:i:s}');
        //$mpdf -> allow_charset_conversion = true;
        //$mpdf -> debug = true;
        $stylesheet = file_get_contents(base_url().'assets/css/bootstrap.css');
        $mpdf -> WriteHTML($stylesheet,1);
        $mpdf -> WriteHTML($html,2);
        //$mpdf -> Output('file.pdf', D);
        $mpdf -> Output( $opis .'_broj_'.$broj->do_broj.'.pdf', I);
        ob_end_flush();        
        
    }  
    
    
    public function pdfskini($id,  $idvrstaDok, $oznaka, $opis){
     //$id = $this->input->post('id');
        ob_start();

        $fiID =  $this->session->userdata('firmaID');
        $broj =   $this->dokumenti->getById("dokument", "do_id", $id);         
        $firma =  $this->dokumenti->getById("firma", "fi_id", $fiID);
            
        $data = array(
            'prikaziStavke' => $this->dokumenti->getstavke($id) ,
            'firma' => $this->dokumenti->getById("firma", "fi_id", $fiID) ,
            'zaglavlje' => $this->dokumenti->getDokumentZag($id) ,
            'vrstaDokumenta' => $this->dokumenti->vrstaDokumenta($idvrstaDok),
            'rekapitualcijaporeza' => $this->dokumenti->rekapitulacijaporeza($id)
            ); 
        $data['firma'] = $firma;   
        
        if($broj->Partner_pa_id)
        {
         $data['partner'] = $this->dokumenti->getById("partner", "pa_id", $broj->Partner_pa_id);
        }   
         
        $data['sume'] = $this->dokumenti->sume($id);             
        
        if($oznaka =="ponuda")
        {
            $html = $this->load->view('sifarnici/dokument/PDF/pdf_ponuda', $data, true);  
        }
        else
        {
            if($this->session->userdata('UsustavuPDV') == 1)
            {
                $html = $this->load->view('sifarnici/dokument/PDF/pdf_racunPDV', $data, true);   
            }
            else
            {
                $html = $this->load->view('sifarnici/dokument/PDF/pdf_racun', $data, true);   
            }
        }

        // render the view into HTML
        //$html = 'asdasd asd asd as a ';
        $this->load->library('mpdf');
        $mpdf = new mPDF('utf-8','A4');
        $mpdf->SetHTMLFooter('
        <table width="100%" style="border-top: 1px solid; vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000;"><tr>
        <td width="10%"></span></td>
        <td width="80%" align="center" style="font-style: italic;">'. $firma->fi_opis.'</td>
        <td width="10%" style="text-align: right;  ">{PAGENO}/{nbpg}</td>
        </tr></table>
        ');
        $mpdf->setHeader('{DATE d.m.Y H:i:s}');

        $mpdf -> allow_charset_conversion = true;
        //$mpdf -> debug = true;
        $stylesheet = file_get_contents(base_url().'assets/css/bootstrap.css');
        $mpdf -> WriteHTML($stylesheet,1);
        $mpdf -> WriteHTML($html,2);
        $mpdf -> Output( $opis ."_broj_" .$broj->do_broj.'.pdf', D);
        //$mpdf->Output();
        ob_end_flush();
               
    }  
    
    
    
    public function pdfskiniMobilno($id,$idvrstaDok){
       
        $vrstaDok = $this->dokumenti->vrstaDokumenta($idvrstaDok); 

        $oznaka = $vrstaDok->vd_oznaka;
        $opis = $vrstaDok->vd_oznaka;
   
        ob_start();

        $fiID =  $this->session->userdata('firmaID');
        $broj =   $this->dokumenti->getById("dokument", "do_id", $id);         
        $firma =  $this->dokumenti->getById("firma", "fi_id", $fiID);   
        
        
        $data = array(
            'prikaziStavke' => $this->dokumenti->getstavke($id) ,
            'firma' => $this->dokumenti->getById("firma", "fi_id", $fiID) ,
            'zaglavlje' => $this->dokumenti->getDokumentZag($id) ,
            'vrstaDokumenta' => $this->dokumenti->vrstaDokumenta($idvrstaDok),
            'rekapitualcijaporeza' => $this->dokumenti->rekapitulacijaporeza($id)
            ); 
        $data['firma'] = $firma; 
        
        if($broj->Partner_pa_id)
        {
         $data['partner'] = $this->dokumenti->getById("partner", "pa_id", $broj->Partner_pa_id);
        }   
             
        $data['sume'] = $this->dokumenti->sume($id);             
        
        if($oznaka =="ponuda")
        {
            $html = $this->load->view('sifarnici/dokument/PDF/pdf_ponuda', $data, true);  
        }
        else
        {
            if($this->session->userdata('UsustavuPDV') == 1)
            {
                $html = $this->load->view('sifarnici/dokument/PDF/pdf_racunPDV', $data, true);   
            }
            else
            {
                $html = $this->load->view('sifarnici/dokument/PDF/pdf_racun', $data, true);   
            }
        }
        
        

         // render the view into HTML
        //$html = 'asdasd asd asd as a ';
        $this->load->library('mpdf');
        $mpdf = new mPDF('utf-8','A4');
        $mpdf->SetHTMLFooter('
        <table width="100%" style="border-top: 1px solid; vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000;"><tr>
        <td width="10%"></span></td>
        <td width="80%" align="center" style="font-style: italic;">'. $firma->fi_opis.'</td>
        <td width="10%" style="text-align: right;  ">{PAGENO}/{nbpg}</td>
        </tr></table>
        ');
        $mpdf->setHeader('{DATE d.m.Y H:i:s}');

        $mpdf -> allow_charset_conversion = true;
        //$mpdf -> debug = true;
        $stylesheet = file_get_contents(base_url().'assets/css/bootstrap.css');
        $mpdf -> WriteHTML($stylesheet,1);
        $mpdf -> WriteHTML($html,2);
        $mpdf -> Output( $opis ."_broj_" .$broj->do_broj.'.pdf', D);
        //$mpdf->Output();
        ob_end_flush();
        
        
    } 
      
  }
?>
