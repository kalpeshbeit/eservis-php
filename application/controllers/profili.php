<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profili extends MY_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('profil');    
    }
    

    public function index()
    {      
        $this->load->view('pocetna');       
    }    
    
    
      public function uredjivanje($table) {
        
        $id = $this->input->post('id');

        if(!$id)
        {
            $id=  $this->session->userdata('firmaID');
        } 
        $fieldId = $this->getFieldId($table);
        $object  = $this->profil->getById($table, $fieldId, $id);
        $firma = $this->profil->getById("firma", "fi_id", $this->session->userdata('firmaID'));
        
        //$this->session->set_userdata('slika_logo', $firma->fi_logo);
        //$data = $this->getVars($table, $id);
        $data['object']     = $object;
        $data['firma']     = $firma;
        $data['id']   = $id;

        $this->load->view('profil/profil', $data);          
    }  
    
    
    public function uredjivanjeAction($table) {
        $firma = $this->profil->getById("firma", "fi_id", $this->session->userdata('firmaID'));
        $id = $this->input->post('id');
        
        if(!$id)
        {
            $id=  $this->session->userdata('firmaID');
        }
        
        
        $fieldId = $this->getFieldId($table);
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
            
            case 'firma':
                $this->form_validation->set_rules('oib', 'Oib', 'required|min_length[11]|max_length[11]|xss_clean');
                $this->form_validation->set_rules('naziv', 'naziv', 'required|min_length[3]|max_length[70]|xss_clean');
                $this->form_validation->set_rules('mjesto', 'Mjesto', 'trim|required|min_length[3]|max_length[50]|xss_clean');
                $this->form_validation->set_rules('adresa', 'Adresa', 'trim|required|min_length[3]|max_length[50]|xss_clean');
                $this->form_validation->set_rules('posta', 'Posta', 'trim|required|min_length[1]|max_length[5]|xss_clean');
                $this->form_validation->set_rules('fax', 'Fax', 'trim|min_length[0]|max_length[15]|xss_clean');
                $this->form_validation->set_rules('iban', 'IBAN', 'trim|required|xss_clean');
                $this->form_validation->set_rules('telefon', 'Telefon', 'trim|min_length[0]|max_length[30]|xss_clean');
                $this->form_validation->set_rules('mobitel', 'Mobitel', 'trim|min_length[0]|max_length[15]|xss_clean');
                $this->form_validation->set_rules('mail', 'Email', 'valid_email|xss_clean');  

                break;
        }
         


        
        
        if ($this->form_validation->run()) {
            switch ($table) {
                 case 'operater':
                     $data = array(
                       'op_ime'            => $this->input->post('ime'),
                       'op_prezime'        => $this->input->post('prezime'),
                       'op_aktivan'        => $this->input->post('aktivan'),
                       'op_mail'           => $this->input->post('email'),          
                       'op_oib'            => $this->input->post('oib'),              
                       'op_telefon'        => $this->input->post('telefon'),              
                       'firma_fi_id'       => $this->session->userdata('firmaID'),
                       'op_id'             => $this->input->post('id'),
                       'op_avatar'         => ($_FILES['slika']['name'] != '') ? $_FILES['slika']['name'] : $this->session->userdata('slika')
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
                        'fi_logo'            => ($_FILES['slika_logo']['name'] != '') ? $_FILES['slika_logo']['name'] : $this->session->userdata('slika_logo'),  
                        'fi_fax'             => $this->input->post('fax'),    
                        'fi_mail'            => $this->input->post('mail'),    
                        'fi_mobitel'         => $this->input->post('mobitel'),    
                        'fi_aktivna'         => $this->input->post('aktivan'),    
                        'fi_usustavuPDV'     => $this->input->post('sustavPDV'), 
                        'fi_opis'            => $this->input->post('opis') 
                    );
                    
                     //promijeni podatak o sustavu pdva u sesiji
                    if($this->input->post('sustavPDV') == 0)
                    {
                        $this->session->set_userdata('UsustavuPDV', 0);
                    }
                    else
                    {
                        $this->session->set_userdata('UsustavuPDV', 1);
                    }
                    break;
            }
            
           
            //ako prodje update upload slike
            if ($this->profil->update($table, $fieldId, $id, $data)) 
            {    
                //echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no a&#382;urirana '.$table.'! </div>'));                                                                                                                                                                              

                if (!empty($_FILES['slika_logo'])) {
                    if($this->upload_logo($id, $table))
                    {
                        echo json_encode(array('uspjelo'=>'1', 'slika' =>  $this->session->userdata('slika_logo' ), 'poruka' => '<div class="alert alert-success">Uspje&#353;no a&#382;urirana '.$table.'! </div>'));                                                                                                                                                                              
                    }
                    else
                    {
                        echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no a&#382;urirana '.$table.'! </div>'));                                                                                                                                                                              
                    }  
                 }
                 else if (!empty($_FILES['slika'])) 
                 {                      
                    if($this->upload($id, $table))
                    {
                        echo json_encode(array('uspjelo'=>'1', 'slika' =>  $this->session->userdata('slika' ), 'poruka' => '<div class="alert alert-success">Uspje&#353;no a&#382;urirana '.$table.'! </div>'));                                                                                                                                                                             

                    }
                    else
                    {
                        echo json_encode(array('uspjelo'=>'1', 'poruka' => '<div class="alert alert-success">Uspje&#353;no a&#382;urirana '.$table.'! </div>'));                                                                                                                                                                              

                    }
                 }
        
             }
          
            

        } 
        else 
        {
            echo json_encode(array('uspjelo'=>'0', 'slika' =>  $this->session->userdata('slika_logo' ), 'poruka' => '<div class="alert alert-warning">Nije uspjelo spremanje '.$table.'! </div>'));                                                                                                                                                                                                                                                                                                                 
        }
     
    }
    
    
    public function dodaj($table) { 
     
        $data = $this->getVars($table);
        $data['tablica'] = $table;
        $this->load->view('postavke/uredi_'.$table, $data);
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
    
    private function getVars($table, $id = null) {

        switch ($table) {
            case 'operater':
                $id = $this->input->post('id');
                $prodajnamjesta = $this->postavka->getFromTable('prodajnomjesto');
                $data = array(
                     'prodajnomjesto'     =>  $prodajnamjesta
                );
                break;    
            default:
                $tablica = $this->admin->getFromTable($table);
                $data['table'] = $tablica;
                break;
        }

        return $data;
    }
    

    
    public function upload($id, $table) {

         $fieldId = $this->getFieldId($table);
         $folderName = "assets/img/".$this->session->userdata('firmaID');

          if(!is_dir($folderName))
          {
            mkdir($folderName,0770);
          } 
          
          if(!is_dir($folderName.'/'.$table))
          {
              mkdir($folderName.'/'.$table,0770);  
          }            
          
          
          if(!is_dir($folderName.'/'.$table.'/'.$id))
          {
              mkdir($folderName.'/'.$table.'/'.$id,0770);  
          } 
          else
          {
                $files = glob($folderName.'/'.$table.'/'.$id.'/*'); // get all file names
                foreach($files as $file){ // iterate files
                  if(is_file($file))
                    unlink($file); // delete file
                }
          }                               

        $config['upload_path']      = 'assets/img/'.$this->session->userdata('firmaID').'/'.$table.'/'.$id;
        $config['allowed_types']    = 'jpg|jpeg|png|bmp';
        $config['file_name']        =  $_FILES['slika']['name'];
        $config['overwrite']        = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('slika')) {
            return FALSE;
        } else {

            # Save image to database
            $image_data = $this->upload->data();
            $file_name = $image_data['file_name'];

            $name_ex = explode(".", $image_data['file_name']);
            $thumb_name = $name_ex[0];

            $pos = strrpos($file_name, '.');
            $ext = substr($file_name, $pos);

            $path_original    = 'assets/img/'.$this->session->userdata('firmaID').'/'.$table.'/'.$id.'/'.$_FILES['slika']['name'];
            $data = array(
                'op_avatar'            =>  $path_original       
            );  
            
            $return = ($this->my_model->update($table, $fieldId, $id, $data)) ? TRUE : FALSE;

            $this->session->set_userdata('slika', $path_original); 
            
            
            # Create THUMBNAIL
            /*$config['image_library'] = 'gd2';
            $config['source_image'] = $image_data['full_path'];
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 300;
            $config['height'] = 300;
            $config['file_name'] = $id.'_thumb.png';
            */
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();  
            
            # Resize original
            $config['image_library']     = 'gd2';
            $config['source_image']     = $image_data['full_path'];
            $config['maintain_ratio']     = TRUE;
            $config['create_thumb']     = FALSE;
            $config['overwrite']         = TRUE;
            //$config['width']             = 1024;
            $config['width']             = 200;
            $config['height']             = 200;  

            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $this->image_lib->resize();

            return $return;
        } 
    }
    
    
    
    
    public function upload_logo($id,$table) {

         $fieldId = $this->getFieldId($table);
         $folderName = "assets/img/".$this->session->userdata('firmaID');

          if(!is_dir($folderName))
          {
            mkdir($folderName,0770);
          }
           
          if(!is_dir($folderName.'/'.$table))
          {
              mkdir($folderName.'/'.$table,0770);  
          }
          else
          {
                $files = glob($folderName.'/'.$table.'/*'); // get all file names
                foreach($files as $file){ // iterate files
                  if(is_file($file))
                    unlink($file); // delete file
                }
          }                     

        $config['upload_path']      = 'assets/img/'.$this->session->userdata('firmaID').'/'.$table;
        $config['allowed_types']    = 'jpg|jpeg|png|bmp';
        $config['file_name']        =  $_FILES['slika_logo']['name'];
        $config['overwrite']        = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('slika_logo')) {
            return FALSE;
        } else {
             
            # Save image to database
            $image_data = $this->upload->data();
            $file_name = $image_data['file_name'];

            $name_ex = explode(".", $image_data['file_name']);
            $thumb_name = $name_ex[0];

            $pos = strrpos($file_name, '.');
            $ext = substr($file_name, $pos);

            $path_original    = 'assets/img/'.$this->session->userdata('firmaID').'/'.$table.'/'.$_FILES['slika_logo']['name'];
            $data = array(
                'fi_logo'            =>  $path_original
            );    

            $return = ($this->my_model->update($table, $fieldId, $id, $data)) ? TRUE : FALSE;
             
            $this->session->set_userdata('slika_logo', $path_original);  
            
            # Create THUMBNAIL
            /*$config['image_library'] = 'gd2';
            $config['source_image'] = $image_data['full_path'];
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 300;
            $config['height'] = 300;
            $config['file_name'] = $id.'_thumb.png';
            */
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();  
            
            # Resize original
            $config['image_library']     = 'gd2';
            $config['source_image']     = $image_data['full_path'];
            $config['maintain_ratio']     = TRUE;
            $config['create_thumb']     = FALSE;
            $config['overwrite']         = TRUE;
            //$config['width']             = 1024;
            $config['width']             = 200;
            $config['height']             = 200;

            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $this->image_lib->resize();

            return $return;
        } 
    }
    
    
    public function brisanje_logo($table) {
        
        $fieldId = $this->getFieldId($table);

        # brisanje slika
        

        $id=  $this->session->userdata('firmaID');
        $firma  = $this->profil->getById($table, $fieldId, $id); 
        //dohvati putanju iz baze za brisanje
        $path =  $firma->fi_logo; 
        $putanja_default =  base_url().'assets/img/default_logo.png';
        $path_original    = NULL;
        $data = array(
            'fi_logo'            =>  $path_original
        );
      
        
        unlink($path);
        
        //$this->session->set_userdata('slika_logo', $putanja_default);
   
          $this->session->unset_userdata('slika_logo');   

        //$id=  $this->session->userdata('firmaID');
      

        $this->my_model->update($table, $fieldId, $id, $data);
        
        echo json_encode(array('uspjelo'=>'1', 'slika' =>  $putanja_default, 'poruka' => '<div class="alert alert-success">Slika uklonjena! </div>')); 
        

    } 
    
    
    public function brisanje_avatar($table) {
        
        $fieldId = $this->getFieldId($table);
        $id = $this->input->post('id');
        # brisanje slika
        
      
            $path = $this->session->userdata('slika' );  
            $putanja_default =  base_url().'assets/img/default_avatar.jpg';
            $path_original    = NULL;
            $data = array(
                'op_avatar'            =>  $path_original
            );
        
        
        unlink($path);
        
      
        $this->session->unset_userdata('slika');   
        
        

        $this->my_model->update($table, $fieldId, $id, $data);
        
        echo json_encode(array('uspjelo'=>'1', 'slika' =>  $putanja_default, 'poruka' => '<div class="alert alert-success">Slika uklonjena! </div>')); 
        

    }
    
}
  
?>
