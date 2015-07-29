<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dokumenti extends My_model {
    
    public function getDokument($id){
        $sql="SELECT dokument.*, concat(operater.op_ime,' ', operater.op_prezime) as operater, vrstadokumenta.vd_id, vrstadokumenta.vd_oznaka FROM dokument JOIN operater ON dokument.operater_op_id = operater.op_id  JOIN vrstadokumenta ON vrstadokumenta.vd_id = dokument.vrstadokumenta_vd_id
        where dokument.vrstadokumenta_vd_id =" .$id. " and dokument.firma_fi_id =". $this->session->userdata('firmaID')." order by dokument.do_broj desc";

        $query = $this->db->query($sql);
        return $query->result();        

    }     
    
    
    public function getDokumentZag($id){
        $sql="SELECT dokument.*, partner.pa_naziv as partner, concat(operater.op_ime,' ', operater.op_prezime) as operater, vrstadokumenta.vd_id, vrstadokumenta.vd_oznaka, naplatniuredjaj.nu_broj as NU, prodajnomjesto.pm_oznaka as PP, sredstvoplacanja.sp_opis, sredstvoplacanja.sp_fiskalizirati FROM dokument JOIN sredstvoplacanja ON sredstvoplacanja.sp_id = dokument.sredstvoplacanja_sp_id JOIN operater ON dokument.operater_op_id = operater.op_id  JOIN vrstadokumenta ON vrstadokumenta.vd_id = dokument.vrstadokumenta_vd_id  LEFT JOIN prodajnomjesto on prodajnomjesto.pm_id = dokument.prodajnoMjesto_pm_id LEFT JOIN naplatniuredjaj on naplatniuredjaj.nu_ID = dokument.naplatniuredjaj_nu_id  left outer join partner on partner.pa_id = dokument.Partner_pa_id 
        where dokument.firma_fi_id =". $this->session->userdata('firmaID')." and dokument.do_id =".$id;

        $query = $this->db->query($sql);
        $result = $query->result();
        return $result[0];        

    }    
    
    public function getArtiklPodaci($id){
        $sql="SELECT artikl.*, porez.pz_posto as pdv FROM artikl JOIN porez ON porez.pz_id = artikl.porez_pz_id 
        where artikl.ar_id =".$id;

        $query = $this->db->query($sql);
        $result = $query->result();
        return $result[0];        

    }
    
    function getstavke($id){  
                  
        $sql="SELECT stavkedokumenta.*, artikl.ar_naziv as naziv, artikl.ar_opis from stavkedokumenta left outer JOIN artikl on artikl.ar_id = stavkedokumenta.artikl_ar_ID 
        where dokument_do_id =" .$id;

        $query = $this->db->query($sql);
        return $query->result();       

    }     
    
    
    function getstavka($id){  
                  
        $sql="SELECT stavkedokumenta.*, artikl.ar_naziv as naziv, artikl.ar_opis from stavkedokumenta left outer JOIN artikl on artikl.ar_id = stavkedokumenta.artikl_ar_ID 
        where sd_id =" .$id;

        $query = $this->db->query($sql);
        $result = $query->result();
        return $result[0];               

    }    
    
    public function getArtikl(){
        $sql="SELECT artikl.*, porez.pz_posto FROM artikl left join porez on artikl.porez_pz_id = porez.pz_id
            where  artikl.ar_aktivan = 1 and firma_fi_id =". $this->session->userdata('firmaID');

        $query = $this->db->query($sql);
        return $query->result();
    }    
    
    
    public function getPartner(){
        $sql="SELECT partner.* FROM partner
            where firma_fi_id =". $this->session->userdata('firmaID');

        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function getPorezneStope(){  
        if($this->session->userdata('UsustavuPDV') == 1)
        {
            $sql="SELECT porez.*, poreznastopa.pzs_naziv, poreznastopa.pzs_sifra FROM porez left join poreznastopa on poreznastopa.pzs_id = porez.poreznaStopa_pzs_ID where CURDATE() between porez.PZ_DATUMOD and porez.PZ_DATUMDO order by pz_posto desc";
        }
        else
        {
             $sql="SELECT porez.*, poreznastopa.pzs_naziv, poreznastopa.pzs_sifra FROM porez left join poreznastopa on poreznastopa.pzs_id = porez.poreznaStopa_pzs_ID where CURDATE() between porez.PZ_DATUMOD and porez.PZ_DATUMDO and  poreznastopa.pzs_sifra = 00 order by pz_posto desc";
        }  
        $query = $this->db->query($sql);
        return $query->result();
    }     
    
                    
    public function getPorezneStopeSifra($posto)
    {  

        $sql="SELECT porez.*, poreznastopa.pzs_naziv, poreznastopa.pzs_sifra FROM porez left join poreznastopa on poreznastopa.pzs_id = porez.poreznaStopa_pzs_ID where CURDATE() between porez.PZ_DATUMOD  and porez.PZ_DATUMDO and porez.pz_posto =" .$posto. " order by pz_posto desc";

        $query = $this->db->query($sql);
        $result = $query->result();
        return $result[0];      
          
    }     
    
    
    
    public function getProdajnaMjesta(){
        $sql="select prodajnomjesto.* from prodajnomjesto where prodajnomjesto.pm_id in (select naplatniuredjaj.prodajnoMjesto_pm_id from naplatniuredjaj) and (pm_zatvoreno = 0 or pm_zatvoreno =1 ) and (pm_datumzatvaranja is null or pm_datumzatvaranja >= CURDATE())  and (pm_datumRegistracije is not null or pm_datumRegistracije !='')   and pm_datumOtvaranja <= CURDATE()   and  prodajnomjesto.firma_fi_id =". $this->session->userdata('firmaID'); 

        $query = $this->db->query($sql);
        return $query->result();
    }     
    
    public function getProdajnaMjestaSva(){
        $sql="select prodajnomjesto.* from prodajnomjesto where prodajnomjesto.pm_id in (select naplatniuredjaj.prodajnoMjesto_pm_id from naplatniuredjaj)  and  prodajnomjesto.firma_fi_id =". $this->session->userdata('firmaID'); 

        $query = $this->db->query($sql);
        return $query->result();
    }    
    
    
    public function getPP($id){
        $sql="select prodajnomjesto.* from prodajnomjesto where pm_id =".$id." and pm_datumOtvaranja is not null "; 

        $query = $this->db->query($sql);
        //return $query->result();

        return $query->num_rows();
    }     
    
    
    
    public function getNaplatniUredjaj($id){      
        $sql="SELECT naplatniuredjaj.* from naplatniuredjaj  where prodajnoMjesto_pm_id =".$id; 

        $query = $this->db->query($sql);
        return $query->result(); 
                   
    }   
    
    public function getMjere(){
        $sql="SELECT jedinicamjere.* FROM jedinicamjere order by jm_rednibroj";

        $query = $this->db->query($sql);
        return $query->result();
    }    
    
    
    public function getSredstvoPlacanja(){
        $sql="SELECT sredstvoplacanja.* FROM sredstvoplacanja";

        $query = $this->db->query($sql);
        return $query->result();
    }    
    
    public function getSredPlacanja($id){
        $sql="SELECT sredstvoplacanja.*,sredstvoplacanja.sp_fiskalizirati as placeno FROM sredstvoplacanja where sp_id=".$id;

        $query = $this->db->query($sql);
        $result = $query->result();
        return $result[0];
    }
    
    
    public function vrstaDokumenta($id = NULL){
        //da bi ovisno o odabiru iz menija postavili odgovarajuce parametre vrste dokumenta
        //neovisno o njihovom broju
        $sql="SELECT vrstadokumenta.* FROM vrstadokumenta where vd_id =".$id;
    
        if($id)
        {
              $query = $this->db->query($sql);
              $result = $query->result();
              return $result[0];
        }
        else
        {
             $query = $this->db->query($sql);
             return $query->result();
        }
    } 
    
    public function post_validacija($table,$id) {
        
        $this->load->library('form_validation');

        switch ($table) {
            case 'operater':
                $this->form_validation->set_rules('ime', 'Ime', 'trim|required|min_length[3]|max_length[25]|xss_clean');
                $this->form_validation->set_rules('prezime', 'Prezime', 'trim|required|min_length[3]|max_length[30]|xss_clean');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
                
                //ako radi azuriranje ne azuriraj sifre zbog enkripcije
                if(!$id)
                {
                    $this->form_validation->set_rules('password', 'Lozinka', 'required|matches[confirmPassword]|xss_clean');
                    $this->form_validation->set_rules('confirmPassword', 'Lozinka potvrde', 'required|xss_clean'); 
                }
              
                $this->form_validation->set_rules('oib', 'Oib', 'required|min_length[11]|max_length[11]|xss_clean');
                break;
            
            case 'artikl':
                $this->form_validation->set_rules('sifra', 'Sifra', 'trim|required|min_length[1]|max_length[6]|xss_clean');
                $this->form_validation->set_rules('naziv', 'Naziv', 'trim|required|min_length[3]|max_length[100]|xss_clean');
                $this->form_validation->set_rules('serijski', 'Serijski', 'trim|min_length[0]|max_length[45]|xss_clean');
                $this->form_validation->set_rules('cijena', 'Cijena', 'trim|required|min_length[0]|max_length[16]|xss_clean');
                $this->form_validation->set_rules('opis', 'Opis', 'trim|min_length[0]|max_length[255]|xss_clean');
                break;   
            case 'naplatniuredjaj':
                $this->form_validation->set_rules('naplatniuredjaj', 'Naplatni uredjaj', 'trim|required|min_length[1]|max_length[20]|numeric|xss_clean');
                $this->form_validation->set_rules('poslovniprostor', 'Poslovni prostor', 'trim|required|min_length[1]|max_length[6]|xss_clean');
                break;  
            
            case 'partner':
                $this->form_validation->set_rules('naziv', 'Naziv', 'trim|required|min_length[1]|max_length[50]|xss_clean');
                $this->form_validation->set_rules('mjesto', 'Mjesto', 'trim|min_length[0]|max_length[30]|xss_clean');
                $this->form_validation->set_rules('adresa', 'Adresa', 'trim|min_length[0]|max_length[50]|xss_clean');
                $this->form_validation->set_rules('posta', 'Posta', 'trim|min_length[0]|max_length[5]|xss_clean');
                $this->form_validation->set_rules('telefon', 'Telefon', 'trim|min_length[0]|max_length[30]|xss_clean');
                $this->form_validation->set_rules('web', 'Web', 'trim|min_length[0]|max_length[60]|xss_clean');
                $this->form_validation->set_rules('mail', 'Email', 'required|min_length[6]|max_length[100]|valid_email|xss_clean');
                $this->form_validation->set_rules('fax', 'Fax', 'min_length[0]|max_length[20]|xss_clean');             
                $this->form_validation->set_rules('oib', 'Oib', 'min_length[11]|max_length[11]|xss_clean');
                $this->form_validation->set_rules('ziro', 'Ziro', 'min_length[6]|max_length[50]|xss_clean');
                $this->form_validation->set_rules('maticni', 'Maticni', 'min_length[6]|max_length[20]|xss_clean');
                $this->form_validation->set_rules('opaska', 'Opaska', 'min_length[0]|max_length[255]||xss_clean');
                break; 
                
            case 'prodajnomjesto':
                $this->form_validation->set_rules('poslovniprostor', 'ProdajnoMjesto', 'trim|required|min_length[1]|max_length[20]|xss_clean');
                $this->form_validation->set_rules('oib', 'Oib', 'required|min_length[11]|max_length[11]|xss_clean');
                $this->form_validation->set_rules('oibProizvodjaca', 'Oib proizvodjaca', 'required|min_length[11]|max_length[11]|xss_clean');
                $this->form_validation->set_rules('mjesto', 'Mjesto', 'trim|min_length[0]|max_length[35]|xss_clean');
                $this->form_validation->set_rules('ulica', 'Ulica', 'trim|min_length[0]|max_length[100]|xss_clean');
                $this->form_validation->set_rules('opcina', 'Opcina', 'trim|min_length[0]|max_length[35]|xss_clean');
                $this->form_validation->set_rules('posta', 'Posta', 'trim|min_length[0]|max_length[12]|xss_clean');
                $this->form_validation->set_rules('kucniBroj', 'KucniBroj', 'trim|min_length[0]|max_length[4]|xss_clean');
                $this->form_validation->set_rules('radnoVrijeme', 'Radno vrijeme', 'trim|required|min_length[1]|max_length[100]|xss_clean');
                $this->form_validation->set_rules('datumPocetkaPrimjene', 'Datum pocetna primjene', 'trim|required|xss_clean');
                break;
            
            case 'firma':
                $this->form_validation->set_rules('naziv', 'Naziv', 'trim|required|min_length[1]|max_length[15]|xss_clean');
                $this->form_validation->set_rules('oib', 'Oib', 'required|min_length[11]|max_length[11]|xss_clean');
                $this->form_validation->set_rules('oibProizvodjaca', 'Oib proizvodjaca', 'required|min_length[11]|max_length[11]|xss_clean');
                $this->form_validation->set_rules('mjesto', 'Mjesto', 'trim|required|min_length[1]|max_length[45]|xss_clean');
                $this->form_validation->set_rules('ulica', 'Ulica', 'trim|required|min_length[3]|max_length[45]|xss_clean');
                $this->form_validation->set_rules('opcina', 'Opcina', 'trim|required|min_length[1]|max_length[35]|xss_clean');
                $this->form_validation->set_rules('posta', 'Posta', 'trim|required|min_length[1]|max_length[5]|xss_clean');
                $this->form_validation->set_rules('kucniBroj', 'KucniBroj', 'trim|required|min_length[1]|max_length[15]|xss_clean');
                $this->form_validation->set_rules('radnoVrijeme', 'Radno vrijeme', 'trim|required|min_length[1]|max_length[75]|xss_clean');
                break;            
            
            case 'dokument':
                $this->form_validation->set_rules('partner', 'partner', 'trim|xss_clean');
                break;  
            
            case 'stavkedokumenta':
               $this->form_validation->set_rules('artikl', 'artikl', 'trim|xss_clean');
                break;
        }


        if ($this->form_validation->run()) {
            switch ($table) {
                 case 'operater':
                    if(!$id)
                    {
                        //insert
                      $data = array(  
                        'op_ime'            => $this->input->post('ime'),
                        'op_prezime'        => $this->input->post('prezime'),
                        'op_aktivan'        => $this->input->post('aktivan'),
                        'op_mail'           => $this->input->post('email'),
                        'op_lozinka'        => sha1($this->input->post('confirmPassword')),              
                        'op_oib'            => $this->input->post('oib'),              
                        'op_telefon'        => $this->input->post('telefon'),              
                        'firma_fi_id'       => $this->session->userdata('firmaID')
                        );
                    }
                    else
                    {
                        //ažuriranje
                       $data = array(  
                        'op_ime'            => $this->input->post('ime'),
                        'op_prezime'        => $this->input->post('prezime'),
                        'op_aktivan'        => $this->input->post('aktivan'),
                        'op_mail'           => $this->input->post('email'),          
                        'op_oib'            => $this->input->post('oib'),              
                        'op_telefon'        => $this->input->post('telefon'),              
                        'firma_fi_id'       => $this->session->userdata('firmaID'),
                        'op_id'             => $this->input->post('id')
                        );
                    }       
                    break;
                 
                 case 'artikl':
                    $data = array(
                        'ar_sifra'              => $this->input->post('sifra'),
                        'ar_naziv'              => $this->input->post('naziv'),
                        'ar_opis'               => $this->input->post('opis'),
                        'JedinicaMjere_jm_sifra'=> $this->input->post('jedinica'),
                        'ar_aktivan'            => $this->input->post('aktivan'),
                        'ar_usluga'             => $this->input->post('usluga'),
                        'ar_serijskibroj'       => $this->input->post('serijski'),
                        'ar_malopcijena'        => $this->input->post('cijena'),
                        'porez_pz_id'           => $this->input->post('porez'),
                        'firma_fi_id'           => $this->session->userdata('firmaID')
                    );
                    break; 
                    
                 case 'partner':
                    $data = array(
                        'pa_naziv'              => $this->input->post('naziv'),
                        'pa_mjesto'             => $this->input->post('mjesto'),
                        'pa_adresa'             => $this->input->post('adresa'),
                        'pa_posta'              => $this->input->post('posta'),
                        'pa_telefon'            => $this->input->post('telefon'),
                        'pa_web'                => $this->input->post('web'),
                        'pa_mail'               => $this->input->post('mail'),
                        'pa_fax'                => $this->input->post('fax'),
                        'pa_oib'                => $this->input->post('oib'),
                        'pa_ziroracun'          => $this->input->post('ziro'),
                        'pa_maticnibr'          => $this->input->post('maticni'),
                        'firma_fi_id'           => $this->session->userdata('firmaID'),
                        'pa_opaska'             => $this->input->post('opaska'),
                        'pa_usustavupdv'        => $this->input->post('sustavPDV'),
                        'pa_aktivan'            => $this->input->post('aktivan')
                        
                    );
                    break;   
                    
                    
                 case 'naplatniuredjaj':
                    $data = array(
                        'nu_broj'              => $this->input->post('naplatniuredjaj'),
                        'prodajnoMjesto_pm_id' => $this->input->post('poslovniprostor'),    
                    );
                    break;
                    
                    
                 case 'prodajnomjesto':
                    $data = array(
                        'pm_oznaka'                     => $this->input->post('poslovniprostor'),
                        'pm_ulica'                      => $this->input->post('ulica'),    
                        'pm_kucniBroj'                  => $this->input->post('kucniBroj'),    
                        'pm_kucniBrojDodatak'           => $this->input->post('kucniBrojDodatak'),    
                        'pm_posta'                      => $this->input->post('posta'),    
                        'pm_opcina'                     => $this->input->post('opcina'),    
                        'pm_mjesto'                     => $this->input->post('mjesto'),    
                        'pm_oib'                        => $this->input->post('oib'),    
                        'pm_radnoVrijeme'               => $this->input->post('radnoVrijeme'),    
                        'pm_datumPocetkaPrimjene'       => date('Y-m-d', strtotime($this->input->post('datumPocetkaPrimjene'))),    
                        'pm_oznakaZatvaranja'           => (isset($_POST['oznakaZatvaranja'])) ? $this->input->post('oznakaZatvaranja') : '',    
                        'pm_oibProizvodjacaSoftvera'    => $this->input->post('oibProizvodjaca'),       
                        'firma_fi_id'                   => $this->session->userdata('firmaID'),
                        'pm_ostaliTipovi'               => $this->input->post('ostaliTipovi')     
                    );
                    break; 
                    
                 case 'firma':
                    $data = array(
                        'fi_oib'             => $this->input->post('oib'),
                        'fi_naziv'           => $this->input->post('naziv'),    
                        'fi_adresa'          => $this->input->post('adresa'),    
                        'fi_posta'           => $this->input->post('posta'),    
                        'fi_mjesto'          => $this->input->post('mjesto'),    
                        'fi_telefon'         => $this->input->post('telefon'),    
                        'fi_iban'            => $this->input->post('iban'),  
                        'fi_logo'            => ($_FILES['slika']['name'] != '') ? $_FILES['slika']['name'] : NULL,  
                        'fi_fax'             => $this->input->post('fax'),    
                        'fi_mail'            => $this->input->post('mail'),    
                        'fi_mobitel'         => $this->input->post('mobitel'),    
                        'fi_aktivna'         => $this->input->post('aktivan'),    
                        'fi_usustavuPDV'     => $this->input->post('sustavPDV')  
                    );
                    break; 
                    
                 case 'dokument': 
                    //insert
                   if(!$id)
                    {
                        $data = array(
                            'firma_fi_id'             => $this->session->userdata('firmaID'),    
                            'do_datum'                => date('Y-m-d'),  
                            'do_vrijeme'              => date('H:i'),
                            'do_valuta'               => date('Y-m-d', strtotime($this->input->post('datum_valuta'))),     
                            'do_dvo'                  => date('Y-m-d', strtotime($this->input->post('datum_isporuke'))),                
                            'operater_op_id'          => $this->session->userdata('id_osoba'),
                            'sredstvoplacanja_sp_id'  => $this->input->post('nacin_placanja'), 
                            'vrstadokumenta_vd_id'    => $this->input->post('id_vrsteDokumenta'),
                            'prodajnoMjesto_pm_id'    => ($this->input->post('poslovni_prostor') != '')? $this->input->post('poslovni_prostor'): NULL,
                            'naplatniuredjaj_nu_id'   => ($this->input->post('naplatni_uredjaj') != '')? $this->input->post('naplatni_uredjaj'): NULL,
                            'Partner_pa_id'           => ($this->input->post('partnerID') != '')? $this->input->post('partnerID'): NULL ,
                            'pa_naziv'                => $this->input->post('partnernaziv'),
                            'do_osoba'                => $this->input->post('osoba'),
                            'do_napomena'             => $this->input->post('napomena'),
                            'do_status'               => 'I',
                            'pg_godina'               => date('Y'),
                            'do_mjestoizdavanja'      => $this->input->post('mjesto'),
                            'pa_adresa'               => $this->input->post('adresa'),
                            'pa_mjesto'               => $this->input->post('mjesto_partner'),
                            'pa_posta'                => $this->input->post('posta'),
                            'pa_oib'                  => $this->input->post('oib')
                        );
                    }
                    else
                    {
                        //update
                        //ako je status "Z" dozvoli promjene dodatnih podataka raèuna i kupca
                        if($this->input->post('status') == "Z")
                        {
                            $data = array(
                                'firma_fi_id'             => $this->session->userdata('firmaID'),
                                'operater_op_id'          => $this->session->userdata('id_osoba'),
                                'Partner_pa_id'           => ($this->input->post('partnerID') != '')? $this->input->post('partnerID'): NULL ,
                                'pa_naziv'                => $this->input->post('partnernaziv'),
                                'do_osoba'                => $this->input->post('osoba'),
                                'do_napomena'             => $this->input->post('napomena'),
                                'do_mjestoizdavanja'      => $this->input->post('mjesto'),
                                'do_placeno'              => (isset($_POST['placeno'])) ? $this->input->post('placeno') : 0,                            
                                'pa_adresa'               => ($this->input->post('partnerID') != '')?  NULL : $this->input->post('adresa'),
                                'pa_mjesto'               => ($this->input->post('partnerID') != '')?  NULL : $this->input->post('mjesto_partner'),
                                'pa_posta'                => ($this->input->post('partnerID') != '')?  NULL : $this->input->post('posta'),
                                'pa_oib'                  => ($this->input->post('partnerID') != '')?  NULL : $this->input->post('oib')
                            );
                        }
                        else
                        {
                            //ako je izrada update svega
                            $data = array(
                                'firma_fi_id'             => $this->session->userdata('firmaID'),
                                'do_datum'                => date('Y-m-d'),  
                                'do_vrijeme'              => date('H:i'),
                                'do_valuta'               => date('Y-m-d', strtotime($this->input->post('datum_valuta'))),     
                                'do_dvo'                  => date('Y-m-d', strtotime($this->input->post('datum_isporuke'))),                
                                'operater_op_id'          => $this->session->userdata('id_osoba'),
                                'sredstvoplacanja_sp_id'  => $this->input->post('nacin_placanja'), 
                                'vrstadokumenta_vd_id'    => $this->input->post('id_vrsteDokumenta'),
                                'prodajnoMjesto_pm_id'    => ($this->input->post('poslovni_prostor') != '')? $this->input->post('poslovni_prostor'): NULL,
                                'naplatniuredjaj_nu_id'   => ($this->input->post('naplatni_uredjaj') != '')? $this->input->post('naplatni_uredjaj'): NULL,
                                'Partner_pa_id'           => ($this->input->post('partnerID') != '')? $this->input->post('partnerID'): NULL ,
                                'pa_naziv'                => $this->input->post('partnernaziv'),
                                'do_osoba'                => $this->input->post('osoba'),
                                'do_napomena'             => $this->input->post('napomena'),
                                'do_mjestoizdavanja'      => $this->input->post('mjesto'),
                                'pg_godina'               => date('Y'),
                                'do_placeno'              => (isset($_POST['placeno'])) ? $this->input->post('placeno') : 0,                            
                                'pa_adresa'               => ($this->input->post('partnerID') != '')?  NULL : $this->input->post('adresa'),
                                'pa_mjesto'               => ($this->input->post('partnerID') != '')?  NULL : $this->input->post('mjesto_partner'),
                                'pa_posta'                => ($this->input->post('partnerID') != '')?  NULL : $this->input->post('posta'),
                                'pa_oib'                  => ($this->input->post('partnerID') != '')?  NULL : $this->input->post('oib')
                            );
                        }                        
                    }
                    break; 
                    
                    
                 case 'stavkedokumenta': 
                    $data = array(
                        'dokument_do_id'          =>  $this->input->post('idzag'),    
                        'porez_pz_posto'          =>  $this->input->post('pdv'), 
                        'poreznastopa_pz_sifra'   =>  $this->input->post('pdvsifra'),   
                        'JedinicaMjere_jm_sifra'  =>  $this->input->post('jedinicamjere'),               
                        'sd_kolicina'             =>  $this->input->post('kolicina'),              
                        'sd_cijenabruto'          =>  $this->input->post('cijena'),               
                        'sd_popust'               =>  $this->input->post('popust'),               
                        'Artikl_ar_id'            =>  ($this->input->post('artiklID') != '')? $this->input->post('artiklID'): NULL ,
                        'ar_naziv'                =>  $this->input->post('artiklnaziv'),
                        'sd_iznospopusta'         =>  ($this->input->post('cijena') * ($this->input->post('popust')/100)) * $this->input->post('kolicina'),
                        'sd_cijenaneto'           =>  $this->input->post('cijena') - $this->input->post('cijena') * ($this->input->post('popust')/100), 
                        'sd_iznosneto'            =>  ($this->input->post('cijena') - $this->input->post('cijena') * ($this->input->post('popust')/100)) * $this->input->post('kolicina'),
                        'sd_poreziznos'           =>  (($this->input->post('cijena') - $this->input->post('cijena') * ($this->input->post('popust')/100)) * $this->input->post('kolicina')) *($this->input->post('pdv')/100),
                        'ar_dodatniopis'          =>  ($this->input->post('artiklID') != '')? NULL: $this->input->post('opis'),
                        'operater_op_id'          =>   $this->session->userdata('id_osoba')
                    );
                    break;
            }
            return $data;

        } else {
            return FALSE;
        }
    }
    
    
    
    public function dohvatiBrojDokumenta($id)
    {
        //za trenutnu firmu pokupi i vrati broj sljedeæeg dokumenta za poslovnu godinu ($godina) koja se odreðuje na osnovu datuma dokumenta

        $sql="SELECT se_broj +1 as broj, se_ID as ID FROM serije where vrstadokumenta_vd_id =".$id." and pg_godina = ".date('Y')." and firma_fi_id =".$this->session->userdata('firmaID');
    
              $query = $this->db->query($sql);
              $result = $query->result();
              
              
              if(!$result)
              {
                    //nema u serijama brojaca za odabranu godinu i firmu i vrstu dokumenta pa treba dodati
                    
                    $sql="INSERT INTO serije (vrstadokumenta_vd_id, firma_fi_id, pg_godina) values(".$id.",".$this->session->userdata('firmaID').", ".date('Y').")";
                    $query = $this->db->query($sql);
                    
                    //return $result['broj'] = 1;
                                       
                    $sql="SELECT se_broj +1 as broj, se_ID as ID FROM serije where vrstadokumenta_vd_id =".$id." and pg_godina = ".date('Y')." and firma_fi_id =".$this->session->userdata('firmaID');
    
                    $query = $this->db->query($sql);
                    $result = $query->result();                    
              }
    
             return $result[0];  
        
        
    }
    
    
    public function dohvatiBrojDokumentaRacun($id, $idNU = NULL, $idPP = NULL)
    {
        //za trenutnu firmu pokupi i vrati broj sljedeæeg dokumenta za poslovnu godinu ($godina) koja se odreðuje na osnovu datuma dokumenta

        $sql="SELECT se_broj +1 as broj, se_ID as ID FROM serije where vrstadokumenta_vd_id =".$id." and naplatniUredjaj_na_id = ".$idNU." and prodajnoMjesto_pm_id =".$idPP." and pg_godina = ".date('Y')." and firma_fi_id =".$this->session->userdata('firmaID');  

        $query = $this->db->query($sql);
        $result = $query->result();

        if(!$result)
        {
            //nema u serijama brojaca za odabranu godinu i firmu i vrstu dokumenta pa treba dodati
            
            $sql="INSERT INTO serije (vrstadokumenta_vd_id, firma_fi_id, naplatniUredjaj_na_id,prodajnoMjesto_pm_id, pg_godina) values(".$id.",".$this->session->userdata('firmaID').", ".$idNU.", ".$idPP.", ".date('Y').")";
            $query = $this->db->query($sql);
            
            //return $result['broj'] = 1;
            
            
            $sql="SELECT se_broj +1 as broj, se_ID as ID FROM serije where vrstadokumenta_vd_id =".$id." and naplatniUredjaj_na_id = ".$idNU." and prodajnoMjesto_pm_id =".$idPP." and pg_godina = ".date('Y')." and firma_fi_id =".$this->session->userdata('firmaID');

            $query = $this->db->query($sql);
            $result = $query->result();
            
        }
    
        return $result[0];  
        
        
    }
    
    
    public function suma_porez($id)
    {    
        $q = $this->db->query('SELECT sum(sd_poreziznos) as sumaPorez FROM stavkedokumenta where dokument_do_id ='. $id.'');        
        $res = $q->row_array();
        return $res['sumaPorez'];

    }
      
    public function suma_iznos($id)
    {    
         $q = $this->db->query('SELECT sum(sd_iznosneto) as sumaIznos FROM stavkedokumenta where dokument_do_id ='. $id.'');        
         $res = $q->row_array();
         return $res['sumaIznos'];

    }
    
    public function sume($id)
    {    
        $sql="SELECT sum(sd_iznosneto) as sumaIznos, sum(sd_poreziznos) as sumaPorez, sum(sd_iznospopusta) as sumaPopust FROM stavkedokumenta where dokument_do_id =". $id;

        $query = $this->db->query($sql);
        $result = $query->result();
        return $result[0];        
    }    
    
    public function rekapitulacijaporeza($id)
    {    
         $sql="SELECT sum(sd_iznosneto) as sumaIznosa,  sum(sd_poreziznos) as sumaPorez, porez_pz_posto, poreznastopa.pzs_naziv FROM stavkedokumenta left join poreznastopa on poreznastopa.pzs_sifra = stavkedokumenta.poreznastopa_pz_sifra  where dokument_do_id ='{$id}' group by porez_pz_posto order by porez_pz_posto desc";

         $query = $this->db->query($sql);
         return $query->result(); 
                        
    } 
    
     public function racunizponudeZag($id){
        $sql4="DROP TABLE IF EXISTS tmp";
        $query = $this->db->query($sql4);        
         
         
        $sql="CREATE TEMPORARY TABLE tmp SELECT * FROM dokument WHERE firma_fi_id =". $this->session->userdata('firmaID')." and dokument.do_id =".$id;
        $query = $this->db->query($sql);
        
        //dohvati PP i NU za racun prvi koji postoji 
        
        
        $prodajnomjesto = $this->dokumenti->getProdajnaMjestaSva();
        $idNU = 0;      
        $idPP = 0;        
        foreach($prodajnomjesto as $prod)
        {
            //dohvati naplatniuredjaj
        
            $data = $this->getNaplatniUredjaj($prod->pm_id);
            
            if($data)
            {
                $idPP  = $prod->pm_id;
                
               foreach($data as $dat)
               {
                   $idNU = $dat->nu_id;
                   break;    
               } 
               break;    
            }
        }
           
                               
        $sql2="UPDATE tmp SET naplatniuredjaj_nu_id = ".$idNU.", prodajnoMjesto_pm_id =".$idPP.",do_id = '', do_broj = '0', vrstadokumenta_vd_id ='2', do_status ='I' WHERE do_id = ".$id."";
        $query = $this->db->query($sql2);

         
        $sql3="INSERT INTO dokument SELECT * FROM tmp";
        $query = $this->db->query($sql3);
        return mysql_insert_id();          
                  

    }       
    
    
    
    public function racunizponudeStavke($id, $idNovog){
        

        $sql4="DROP TABLE IF EXISTS tmp";
        $query = $this->db->query($sql4);        
         
         
        $sql="CREATE TEMPORARY TABLE tmp SELECT * FROM stavkedokumenta WHERE  dokument_do_id =".$id;
        $query = $this->db->query($sql);
         
                               
        $sql2="UPDATE tmp SET dokument_do_id = ".$idNovog." ,sd_id = ''";
        $query = $this->db->query($sql2);

         
        $sql3="INSERT INTO stavkedokumenta SELECT * FROM tmp";
        $query = $this->db->query($sql3);
         

    }      
      
}
?>
