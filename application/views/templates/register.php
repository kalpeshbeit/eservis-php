<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>       
        
    <meta http-equiv="content-type" content="text/html; charset=utf-8 general">
    <title>FORTIS | Registracija korisnika</title>
    <meta name="description" content="description">
    <meta name="author" content="Infromatika Fortuno">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Favicons     ================================================== -->
    
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/img/favicon.png">

   
   <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/bootstrap.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
   <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

   <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>

   <link href="<?php echo base_url(); ?>assets/plugins/select2/select2.css" rel="stylesheet">     
   <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">  
   <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.js" type="text/javascript" charset="utf-8"></script>      
	           
   <!--<script src="http://code.jquery.com/jquery.js"></script>-->
   <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-2.1.0.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui-timepicker-addon/i18n/jquery-ui-timepicker-hr.js"></script>
   <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/i18n/jquery.ui.datepicker-hr.min.js"></script>
   <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/bootstrap.min.js"></script>
   <!-- All functions for this theme + document.ready processing -->
   <script src="<?php echo base_url(); ?>assets/js/fortis.js"></script>      
   
   <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrapvalidator/bootstrapValidator.min.js"></script> 

</head>

<body>
 <!--Start Header-->



<div id="modalbox">
    <div class="devoops-modal">
        <div class="devoops-modal-header">
            <div class="modal-header-name">
                <span>Basic table</span>
            </div>
            <div class="box-icons">
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="devoops-modal-inner">
        </div>
        <div class="devoops-modal-bottom">
        </div>
    </div>
</div>

<header class="navbar">
    <div class="container-fluid expanded-panel">     
        <div class="row">
            <div id="logo" class="col-xs-12 col-sm-2" title="Informatika Fortuno d.o.o.">
                <a target="_blank" href="http://www.fortuno.hr">@FortisWeb</a>
            </div>
            <div id="top-panel" class="col-xs-12 col-sm-10">
                <div class="row">
                    <div class="col-xs-8 col-sm-6">
                        <a href="#" class="show-sidebar">
                          <i class="fa fa-bars"></i>
                        </a>
                        <div id="search">
                            <input type="text" title="<?php echo $this->session->userdata('firma'); ?>" disabled="disabled" value="<?php echo $this->session->userdata('firma'); ?>" />
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-6 top-panel-right">
                        <ul class="nav navbar-nav pull-right panel-menu">
                            <li class="hidden-xs">
                                <a href="#" onclick="info();" title="Kontakt centar">

                                    <i class="fa fa-headphones"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle account" data-toggle="dropdown">
                                    <div class="avatar">
                                        <img id="avatar" src="<?php  echo  $this->session->userdata('slika' )? $this->session->userdata('slika') : base_url().'assets/img/default_avatar.jpg'; ?>" class="img-rounded" alt="avatar" />
                                    </div>
                                    <i class="fa fa-angle-down pull-right"></i>
                                    <div class="user-mini pull-right">
                                        <span class="welcome">Dobro do&#353;li,</span>
                                            <span><?php echo $korisnik->op_ime.' '.$korisnik->op_prezime; ?></span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                     <li>
                                        <a href="<?php echo base_url(); ?>stranica/logout">
                                            <i class="fa fa-power-off"></i>
                                            <span class="sm text">Odustani / odjava</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--End Header-->
<!--Start Container-->
<div id="main" class="container-fluid">
    <div class="row">
        <div id="sidebar-left" class="col-xs-2 col-sm-2">
            <ul class="nav main-menu">
                <li>
                    <a href="#" class="active ajax-link">
                        <i class="fa fa-dashboard"></i>
                        <span class="hidden-xs">Po&#269;etna</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a title="&#352;ifarnici" href="#" class="dropdown-toggle">
                        <i class="fa fa-table"></i>
                        <span class="hidden-xs">&#352;ifarnici</span>
                        <i class="fa fa-chevron-down hidden-xs"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <i class="fa fa-pencil-square-o"></i>   
                        <span class="hidden-xs">Ra&#269;uni i ponude</span>
                        <i class="fa fa-chevron-down hidden-xs"></i>
                    </a>
                   
                </li>                
                        
            </ul>
            
            
        </div>
        <!--Start Content-->
        <div id="content" class="col-xs-12 col-sm-10">
            <div class="preloader"  style="display: none;">
                <img src="<?php echo base_url(); ?>assets/img/devoops_getdata.gif" class="devoops-getdata" alt="preloader"/>
            </div>
            <div id="ajax-content">
                 <?php $this->load->view('registracija'); ?> 
            
            </div>
        </div>
        <!--End Content-->                                                               
    </div>
</div>
<!--End Container-->


<div class="preloader2"  style="display: none;">
    <p><img src="<?php echo base_url(); ?>assets/img/loader.gif" class="devoops-getdata" alt="preloader"/> Pri&#269;ekajte..</p>
</div>





    
<script type="text/javascript"> 
 
     $(document).ready(function() {  
    
      LoadBootstrapValidatorScript(FormValidator);  
    
    
});        


          
</script>



</body>
</html>
      
      


  	

        
 
