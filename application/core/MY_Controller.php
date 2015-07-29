<?php

class MY_Controller extends CI_Controller {

	public function __construct() {
	    parent::__construct();
         $this->load->model('admin');      

         //ako korisnik nije ulogiran prebaci ga na poèetnu
	    if (!$this->session->userdata('is_logged_in')) {
        	redirect(base_url());
        }


        # Put stats in Class-wide variable
	    $id_user 		= $this->session->userdata('id_user');	
	    $tekuca_godina	= date('Y');  
        $vrsteDokumenta = $this->admin->getFromTable('vrstadokumenta');
        $oibProizvodjacaSoftvera = $this->admin->oibProizvodjaca();

	    # Store stats in $data
	    $data = array(
	    	'id_user'		 =>	$id_user,
	    	'tekuca_godina'	 =>	$tekuca_godina,
            'vrsteDokumenta' => $vrsteDokumenta,
            'oibProizvodjaca'=> $oibProizvodjacaSoftvera
	    ); 

	    # Load variables in all views
	    $this->load->vars($data);

	}

}
