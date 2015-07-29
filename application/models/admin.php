<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends My_model {

    public function getOperater(){
        $sql="SELECT operater.* FROM operater
            where firma_fi_id =". $this->session->userdata('firmaID');

        $query = $this->db->query($sql);
        return $query->result();
    }
    
    
    public function getDokument($id){
        $sql="SELECT dokument.*, partner.pa_naziv as partner, concat(operater.op_ime,' ', operater.op_prezime) as operater, naplatniuredjaj.nu_broj as NU, prodajnomjesto.pm_oznaka as PP FROM dokument JOIN operater ON dokument.operater_op_id = operater.op_id LEFT JOIN prodajnomjesto on prodajnomjesto.pm_id = dokument.prodajnoMjesto_pm_id LEFT JOIN naplatniuredjaj on naplatniuredjaj.nu_ID = dokument.naplatniuredjaj_nu_id left outer join partner on partner.pa_id = dokument.Partner_pa_id
        where dokument.vrstadokumenta_vd_id =" .$id. " and dokument.firma_fi_id =". $this->session->userdata('firmaID')." order by dokument.do_broj desc";

        $query = $this->db->query($sql);
        return $query->result();
    }
    
    
    public function getArtikl(){
        $sql="SELECT artikl.*, porez.pz_posto, poreznastopa.pzs_naziv as naziv FROM artikl left join porez on artikl.porez_pz_id = porez.pz_id left join poreznastopa on poreznastopa.pzs_ID = porez.poreznaStopa_pzs_ID
            where firma_fi_id =". $this->session->userdata('firmaID')." order by ar_id desc";

        $query = $this->db->query($sql);
        return $query->result();
    }    
    
    
    public function getPorezneStope(){
        $a =  $this->session->userdata('UsustavuPDV');
        $sql="SELECT porez.*, poreznastopa.pzs_naziv FROM porez left join poreznastopa on poreznastopa.pzs_id = porez.poreznaStopa_pzs_ID where CURDATE() between porez.PZ_DATUMOD and porez.PZ_DATUMDO  order by pz_posto desc";

        $query = $this->db->query($sql);
        return $query->result();
    }                                                                                                                  
    
    public function getMjere(){
        $sql="SELECT jedinicamjere.* FROM jedinicamjere order by jm_rednibroj";

        $query = $this->db->query($sql);
        return $query->result();
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
    
    
    public function oibProizvodjaca($id = NULL){

        $sql="SELECT maticnifortuno.* FROM maticnifortuno";
        
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result[0];
        
     
    }        
    
    public function getPartner(){
        $sql="SELECT partner.* FROM partner
            where firma_fi_id =". $this->session->userdata('firmaID');

        $query = $this->db->query($sql);
        return $query->result();
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
                    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|unique[operater.op_mail]|xss_clean');
                }
              
                $this->form_validation->set_rules('oib', 'Oib', 'numeric|required|min_length[11]|max_length[11]|xss_clean');
                break;
            
            case 'artikl':
                $this->form_validation->set_rules('sifra', 'Sifra', 'trim|required|min_length[1]|max_length[6]|xss_clean');
                
                if(!$id)
                {
                    $this->form_validation->set_rules('sifra','Sifra','required|min_length[1]|max_length[6]|unique[artikl.ar_sifra]|xss_clean');
                }
                               
                
                $this->form_validation->set_rules('naziv', 'Naziv', 'required|trim|min_length[3]|max_length[100]|xss_clean');
                $this->form_validation->set_rules('serijski', 'Serijski', 'trim|min_length[0]|max_length[45]|xss_clean');
                $this->form_validation->set_rules('cijena', 'Cijena', 'required|trim|min_length[0]|max_length[16]|xss_clean');
                $this->form_validation->set_rules('opis', 'Opis', 'trim|min_length[0]|max_length[5000]|xss_clean');
                break;   
            case 'naplatniuredjaj':
                $this->form_validation->set_rules('naplatniuredjaj', 'Naplatni uredjaj', 'trim|required|min_length[1]|max_length[10|numeric|xss_clean');
                $this->form_validation->set_rules('poslovniprostor', 'Poslovni prostor', 'trim|required|xss_clean');
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
                $this->form_validation->set_rules('oib', 'Oib', 'numeric|min_length[11]|max_length[11]|xss_clean');
                $this->form_validation->set_rules('ziro', 'Ziro', 'min_length[6]|max_length[50]|xss_clean');
                $this->form_validation->set_rules('maticni', 'Maticni', 'min_length[6]|max_length[20]|xss_clean');
                $this->form_validation->set_rules('opaska', 'Opaska', 'min_length[0]|max_length[255]||xss_clean');
                break; 
                
            case 'prodajnomjesto':
            
               
                if(!$id)
                {
                    $this->form_validation->set_rules('poslovniprostor', 'Oznaka poslovnog prostora', 'trim|required|min_length[1]|max_length[20]|unique[prodajnomjesto.pm_oznaka]|xss_clean'); 
                }
                else
                {
                    $this->form_validation->set_rules('poslovniprostor', 'Oznaka poslovnog prostora', 'trim|required|min_length[1]|max_length[20]|xss_clean');
                }    
                       
                $this->form_validation->set_rules('oib', 'Oib', 'min_length[11]|max_length[11]|xss_clean');
                $this->form_validation->set_rules('oibProizvodjaca', 'Oib proizvodjaca', 'required|min_length[11]|max_length[11]|xss_clean');
                $this->form_validation->set_rules('mjesto', 'Mjesto', 'trim|min_length[0]|max_length[35]|xss_clean');
                $this->form_validation->set_rules('ulica', 'Ulica', 'trim|min_length[0]|max_length[100]|xss_clean');
                $this->form_validation->set_rules('opcina', 'Opcina', 'trim|min_length[0]|max_length[35]|xss_clean');
                $this->form_validation->set_rules('posta', 'Posta', 'trim|min_length[0]|max_length[12]|xss_clean');
                $this->form_validation->set_rules('kucniBroj', 'KucniBroj', 'trim|min_length[0]|max_length[4]|xss_clean');
                $this->form_validation->set_rules('radnoVrijeme', 'Radno vrijeme', 'trim|min_length[1]|max_length[100]|xss_clean');
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
            }
            return $data;

        } else {
            return FALSE;
        }
    }
    
    
     public function updatePassword($id, $password) {
        $data['op_lozinka'] = $password;
        return $this->update('operater', 'op_id' , $id, $data);
    } 
    
    public function getKorisnici(){
        $sql="select firma.*, (select count(dokument.do_id) from dokument where dokument.firma_fi_id = firma.fi_id  and dokument.vrstadokumenta_vd_id = 2 ) as racun, (select count(dokument.do_id) from dokument where dokument.firma_fi_id = firma.fi_id  and dokument.vrstadokumenta_vd_id = 1 ) as ponuda  from firma";

        $query = $this->db->query($sql);
        return $query->result();
    }
       

}
?>
