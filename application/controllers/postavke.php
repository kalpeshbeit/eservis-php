<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Postavke extends MY_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('postavka');    
    }
    

    public function index()
    {      
        $this->load->view('pocetna');       
    }
    
    
    public function pregled()
    {
        //prodajnomjesto = poslovni prostor
        $prodajnamjesta = $this->postavka->getProdajnoMjesto();
        $naplatniuredjaji = $this->postavka->getNaplatniUredaj();
        $certifikat = $this->postavka->getCertifikat();
        
        $data = array(
                    'prodajnomjesto'     =>  $prodajnamjesta,
                    'naplatniuredjaj'    =>  $naplatniuredjaji,
                    'certifikat'         =>  $certifikat
                );     
                
        $this->load->view('postavke/postavke', $data);  
        
    }
    
    
      public function uredjivanje($table) {
        
        $id = $this->input->post('id');

        $fieldId = $this->getFieldId($table);
        $object  = $this->postavka->getById($table, $fieldId, $id);

        $data = $this->getVars($table, $id);
        $data['object']     = $object;
        $data['id']   = $id;
        $data['tablica']    = $table;

        $this->load->view('postavke/uredi_'.$table, $data);          
    }
    
    
       public function dodaj($table) { 
     
        $data = $this->getVars($table);
        $data['tablica'] = $table;
        $this->load->view('postavke/uredi_'.$table, $data);
    }
    
     private function getFieldId($table) {
        switch ($table) {
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
    
    
    
    private function getVars($table, $id = null) {

        switch ($table) {
            case 'naplatniuredjaj':
                $id = $this->input->post('id');
                $prodajnamjesta = $this->postavka->getProdajnoMjesto();
                $data = array(
                     'prodajnomjesto'     =>  $prodajnamjesta
                );
                break;    
            /*case 'prodajnomjesto':
                $id = $this->input->post('id');
                $prodajnamjesta = $this->postavka->getFromTable('prodajnomjesto');
                $data = array(
                     'prodajnomjesto'     =>  $prodajnamjesta
                );
                break;    */
            default:
                $tablica = $this->admin->getFromTable($table);
                $data['table'] = $tablica;
                break;
        }

        return $data;
    }
    
    
    
    
    public function upload_certifikat($vrsta) {
        
        $data = $this->postavka->post_validacija($vrsta);       
        
        if ($data != FALSE)
        {
            $folderName = "files/certifikati/".$this->session->userdata('firmaID');

            if(!is_dir($folderName))
            {
                mkdir($folderName,0770);
            } 
              
              
            $msg = '';
            $config['upload_path']      = 'files/certifikati/'.$this->session->userdata('firmaID');
            $config['allowed_types']    = 'pfx';
            $config['file_name']        =  $_FILES['certifikat']['name'];
            $config['overwrite']        = TRUE;                          
             
            $this->load->library('upload', $config);
        
            $this->upload->initialize($config);
        
            $this->upload->set_allowed_types('*');
            
            $target_file = 'files/certifikati/'.$this->session->userdata('firmaID').'/'. basename($_FILES["certifikat"]["name"]);
            $uploadOk = 1;
            
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                  
            $info = pathinfo($target_file);

               
            if(preg_match('/\s/',$info['filename']) > 0)
            {
                $msg =  'Naziv certifikata mora biti jedna rijec, koristite "_" ukoliko trebate vise!!!';
                $uploadOk = 0;
            }
            //echo $target_file;
            // Check if file already exists
            if (file_exists($target_file)) {
                $msg =  'File koji ste odabrali vec postoji!!!';
                $uploadOk = 0;
            }
            // Check file size
            //in bytes
            if ($_FILES["certifikat"]["size"] > 5000) {
                $msg = 'File koji pokusavate dodati je preveliki';
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "pfx" && $imageFileType != "cer" && $imageFileType != "p12") {
                $msg = 'Dozvoljeni formati .pfx, .p12, .cer!';
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-warning">'.$msg.'</div>'));                                                                                                                                                                                                                                                                

            // if everything is ok, try to upload file
            } else {
                if (!$this->upload->do_upload('certifikat')) {
                    echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-warning">Dogodila se greska prilikom uploadanja!!! </div>'));                                                                                                                                                                                                                                                                
                } else {
                 
                    # Save image to database
                    $this->upload->data();
                   
                    $path_original    = 'files/certifikati/'.$this->session->userdata('firmaID').'/'.$_FILES['certifikat']['name'];
                    $data['fi_certifikat'] =  $path_original;
                        //'fi_pass'                  => sha1($this->input->post('lozinka'))
                      
                
                    $this->my_model->update("firma", "fi_id", $this->session->userdata('firmaID'), $data);
                    
                    
                    echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no uploadan certifikat!!! </div>'));                                                                                                                                                                                                                                                                
            
                }
            }
        }
    }
    
    
    public function delete_certifikat() {
        
        $id = $this->session->userdata('firmaID');
        
        //ukloni ga iz foldera, isprazni folder
        //update tablice firma - polje fi_certifikat koji sadrži putanju sa praznim stringom

        # brisanje certifikata       

        $id=  $this->session->userdata('firmaID');
        $firma  = $this->postavka->getById("firma", "fi_ID", $id); 
        //dohvati putanju iz baze za brisanje
        $path =  $firma->fi_certifikat; 
        
        $path_original    = NULL;
        
        $data = array(
            'fi_certifikat'   =>  $path_original,
            'fi_pass'         =>  $path_original
        );
        
        unlink($path);

        $this->my_model->update("firma", "fi_ID", $id, $data);
        
        echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Certifikat obrisan! </div>'));        
        
    }
    
    
    public function provjeri_poslovni_prostor()
    {
         //provjeri trenutno odabrani poslovni prostor
         //ukoliko je zatvoren vrati false ukoliko nije true
         $id = $this->input->post('id');
         if($this->postavka->getProdajnoMjestoID($id))
         {
             echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success" >Moze se slati prijava poslovnog prostora! </pre>'));         
         }
         else
         {
             echo json_encode(array('uspjelo'=>'0'));         
         } 
         
    } 
    
    
    public function provjeri_naplatni_uredjaj()
    {
         //provjeri trenutno odabrani naplatni uredjaj
         //ukoliko je dodan racun ne dozvoli promjene oznake
         $idPP = $this->input->post('idPP');
         
         if($this->postavka->getNaplatniUredjajID($idPP))
         {
             echo json_encode(array('uspjelo'=>'0', 'poruka' => '<div class="alert alert-warning">Ne dozvoli editiranje! </div>'));         
         }
         else
         {
             echo json_encode(array('uspjelo'=>'1'));         
         } 
         
    }
}
  
?>
