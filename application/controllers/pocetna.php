<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
  
  
  class Pocetna extends MY_Controller
  {
      public function __construct()
      {
          parent::__construct(); 
          $this->load->language('custom');   
      }

    /**
     * Shows the admin dashboard page
     * 
     * This is the default action for admin Dashboard controller. This function shows the admin dashboard page.
     */
     
     public function index()
     {  
        $this->load->model('pocetna_model');

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
        
        $this->load->template($data);
     } 
  }
?>
