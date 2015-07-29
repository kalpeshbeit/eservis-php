<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pregled extends MY_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pregled_model');    
        $this->load->model('dokumenti');    
    }
    
        
    public function pregled_dok()
    {                   
        $prodajnomjesto =  $this->pregled_model->getProdajnaMjestaSva(); 
         
                $data = array(
                    'prodajnamjesta'          => $prodajnomjesto
                );
        $this->load->view('pregled/pregled', $data);          
    }    
    
    
    
    public function stanje_blagajne()
    {      
         $prodajnomjesto =  $this->pregled_model->getProdajnaMjestaSva(); 
         $vrstaplacanja = $this->dokumenti->getSredstvoPlacanja();     
         
                $data = array(
                    'prodajnamjesta'          => $prodajnomjesto,
                    'sredstvoplacanja' =>   $vrstaplacanja,  
                );
        $this->load->view('pregled/stanje_blagajne', $data);       
    }  
    
    
    public function rekapitulacija()
    {      
         $prodajnomjesto =  $this->pregled_model->getProdajnaMjestaSva(); 
         $vrstaplacanja = $this->dokumenti->getSredstvoPlacanja();     
         
                $data = array(
                    'prodajnamjesta'          => $prodajnomjesto,
                    'sredstvoplacanja' =>   $vrstaplacanja,  
                );
         $this->load->view('pregled/rekapitulacija', $data);       
    }
    
    
    public function process_form($table)
    {
        $datOD = $this->input->post('sifra');
        $datDO = $this->input->post('sifra');
        $pmID = $this->input->post('sifra');
        $vd_ID = $this->input->post('sifra');
        $prodajnomjesto =  $this->pregled_model->getDokument($datOD, $datDO, $pmID, $vd_ID);
        
            $data = array(
                    'prodajnamjesta'          => $prodajnomjesto
                );
        $this->load->view('pregled/pregled', $data);          
    }
    
    
    
     public function prikazi() {
         
         $id = $this->input->post('id');

         $datOD =  date('Y-m-d', strtotime($this->input->post('datumOD')));
         $datDO =  date('Y-m-d', strtotime($this->input->post('datumDO')));

         $tablica = $this->pregled_model->getDokument($id, $datOD, $datDO );

         $data = array(
            'table'             =>  $tablica
         );


         $this->load->view('pregled/pregled_stavke', $data);
              
    }       
     
    
    public function prikaziStanje() {
         
         $id = $this->input->post('id');

         $datOD =  date('Y-m-d', strtotime($this->input->post('datumOD')));
         $datDO =  date('Y-m-d', strtotime($this->input->post('datumDO')));
         

         $pmID = $this->input->post('pmID');
         $nuID = $this->input->post('nuID');
 
         $tablica = $this->pregled_model->getStanjeBlagajne($id, $datOD, $datDO ,$pmID, $nuID);

         $data = array(
            'table'             =>  $tablica
         );

         //generiraj PDF
                       
        $this->pdf($data);
              
    } 
    
    
    public function pdf( $datOD, $datDO ,$pmID, $nuID, $vpID = NULL){
        //$id = $this->input->post('id');
        ob_start();
        
        $fiID =  $this->session->userdata('firmaID');
        
         
        $firma =  $this->dokumenti->getById("firma", "fi_id", $fiID);
        $prodajnomjesto =  $this->dokumenti->getById("prodajnomjesto", "pm_id", $pmID);
        $naplatniuredjaj =  $this->dokumenti->getById("naplatniuredjaj", "nu_id", $nuID);
        
        $id = $this->input->post('id');

        $datOD =  date('Y-m-d', strtotime($datOD));
        $datDO =  date('Y-m-d', strtotime($datDO));
        
        
        $tablica = $this->pregled_model->getStanjeBlagajne($datOD, $datDO ,$pmID, $nuID, $vpID);

        $data = array(
            'table'             =>  $tablica,
            'datOD'             =>  $datOD, 
            'datDO'             =>  $datDO,
            'prodajnomjesto'    =>  $prodajnomjesto,
            'naplatniuredjaj'    => $naplatniuredjaj
         );
         
         $data['firma'] = $firma;  
                  
        $html = $this->load->view('pregled/pdf_stanje', $data, true);   

        // render the view into HTML
        //$html = 'asdasd asd asd as a ';
        $this->load->library('mpdf');
        $mpdf = new mPDF('utf-8','A4');

        $mpdf->SetHTMLFooter('
        <table width="100%" style="border-top: 1px solid; vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000;"><tr>
       
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
        $mpdf -> Output( 'asd.pdf', I);
        ob_end_flush();        
        
    }     
    
    
    public function rekapituliraj( $datOD, $datDO ,$pmID, $nuID, $vpID = NULL){
        //$id = $this->input->post('id');
        ob_start();
        
        $fiID =  $this->session->userdata('firmaID');
        
         
        $firma =  $this->dokumenti->getById("firma", "fi_id", $fiID);
        $prodajnomjesto =  $this->dokumenti->getById("prodajnomjesto", "pm_id", $pmID);
        $naplatniuredjaj =  $this->dokumenti->getById("naplatniuredjaj", "nu_id", $nuID);
        
        $id = $this->input->post('id');

        $datOD =  date('Y-m-d', strtotime($datOD));
        $datDO =  date('Y-m-d', strtotime($datDO));
        
        
        $tablica = $this->pregled_model->getRekapitulacija($datOD, $datDO ,$pmID, $nuID, $vpID);

        $data = array(
            'table'             =>  $tablica,
            'datOD'             =>  $datOD, 
            'datDO'             =>  $datDO,
            'prodajnomjesto'    =>  $prodajnomjesto,
            'naplatniuredjaj'   => $naplatniuredjaj
         );
         
         $data['firma'] = $firma;  
                  
        $html = $this->load->view('pregled/pdf_rekapitualcija', $data, true);   

        // render the view into HTML
        //$html = 'asdasd asd asd as a ';
        $this->load->library('mpdf');
        $mpdf = new mPDF('utf-8','A4');

        $mpdf->SetHTMLFooter('
        <table width="100%" style="border-top: 1px solid; vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000;"><tr>
       
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
        $mpdf -> Output( 'asd.pdf', I);
        ob_end_flush();        
        
    }     
    
    
        
    
    
     
    
}
  
?>
