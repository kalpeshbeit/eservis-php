<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html> 

<head>       
        
    <meta http-equiv="content-type" content="text/html; charset=utf-8 general">
    <title>MobilniUred.Com | Informatika FORTUNO d.o.o..</title>      
    <meta name="description" content="description">
    <meta name="author" content="Infromatika Fortuno">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Favicons     ================================================== -->
    
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/img/favicon.png">

   
   <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/bootstrap.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
   <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

   <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>

   <link href="<?php echo base_url(); ?>assets/plugins/xcharts/xcharts.min.css" rel="stylesheet"> 
   <link href="<?php echo base_url(); ?>assets/plugins/select2/select2.css" rel="stylesheet">     
   <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">       
	           
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

</head>
 <div id ="landing"></div> 
<body>   
 <!--Start Header-->
   <div id="screensaver">
    <canvas id="canvas"></canvas>
    <i class="fa fa-lock" id="screen_unlock"></i>
   </div>  


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

<header id="navigacija" class="navbar">
    <div class="container-fluid expanded-panel">     
        <div class="row">
            <div id="logo" class="col-xs-12 col-sm-2" title="Informatika Fortuno d.o.o.">
                <a target="_blank" href="http://www.fortuno.hr">MobilniUred</a>
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
                                        <span><?php echo $this->session->userdata('ime')." ".$this->session->userdata('prezime'); ?></span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" onclick="profil(<?php echo $this->session->userdata('id_osoba'); ?>);">
                                            <i class="fa fa-user"></i>
                                            <span class="sm text">Profil</span>
                                        </a>
                                    </li>
                                    <li>
                                       <a href="#" onclick="postavke();">          
                                            <i class="fa fa-cog"></i>
                                            <span class="sm text">Postavke</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>stranica/logout">
                                            <i class="fa fa-power-off"></i>
                                            <span class="sm text">Odjava</span>
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
                    <a href="#" onclick="pocetna();" class="active ajax-link">
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
                    <ul class="dropdown-menu">
                        <li><a title="Artikli" class="ajax-link" href="" onclick="artikl();"> 
                        <i class="fa fa-barcode"></i>
                        Artikli
                        </a></li>
                        <li><a title="Operateri" class="ajax-link" href="" onclick="operateri();"> 
                        <i class="fa fa-user"></i>
                        Operateri
                        </a></li>
                        <li><a title="Partneri" class="ajax-link" href="" onclick="partneri();"> 
                        <i class="fa fa-chain"></i>
                        Partneri
                        </a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <i class="fa fa-pencil-square-o"></i>   
                        <span class="hidden-xs">Ra&#269;uni i ponude</span>
                        <i class="fa fa-chevron-down hidden-xs"></i>
                    </a>
                    <ul class="dropdown-menu">
                    
                    <!---ispis vrsta dokumenata i odgovarajucih ID oznaka--->          
                    <?php foreach($vrsteDokumenta as $dokument){ ?>

                        <li value="<?php echo $dokument->vd_id; ?>" onclick="dokument(this);"><a title="<?php echo $dokument->vd_opis; ?>" class="ajax-link" href=""> 
                        <i class="fa fa-file-text"></i>
                        <?php echo $dokument->vd_opis; ?>
                        </a></li>
                    <?php } ?>
          

                    </ul>
                </li> 
                <li class="dropdown">
                    <a title="&#352;ifarnici" href="#" class="dropdown-toggle">
                        <i class="fa fa-search"></i>
                        <span class="hidden-xs">Pregledi</span>
                        <i class="fa fa-chevron-down hidden-xs"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a title="Dokumenati" class="ajax-link" href="" onclick="pregled();"> 
                        <i class="fa fa-file-text"></i>
                        Pregled dokumenata
                        </a></li>
                        <li><a title="Stanje blagajne" class="ajax-link" href="" onclick="stanje_blagajne();"> 
                        <i class="fa fa-euro"></i>
                        Stanje blagajne
                        </a></li> 
                        <li><a title="Rekapitualcija poreza" class="ajax-link" href="" onclick="rekapitulacija();"> 
                        <i class="fa fa-tasks"></i>
                        Rekapitulacija poreza
                        </a></li>
                       
                    </ul>
                </li>
                <?php if($this->session->userdata('firmaID') == 1)
                        { ?>
                <li class="dropdown">
                    <a title="Administracija korisnika" href="#" class="dropdown-toggle">
                        <i class="fa fa-users"></i>
                        <span class="hidden-xs">Administracija korisnika</span>
                        <i class="fa fa-chevron-down hidden-xs"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a title="Artikli" class="ajax-link" href="" onclick="korisnici();"> 
                        <i class="fa fa-search"></i>
                        Pregled svih korisnika
                        </a></li>
                    </ul>
                </li>                                                          
                            
                <?php   }

                 ?>
              
                <li class="dropdown hidden-xs hidden-sm hidden-md">
                    <a  id="locked-screen"  href="" class="dropdown-toggle">
                          <i class="fa fa-lock"></i>
                         <span class="hidden-xs">Screen Saver</span>
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
                   <?php $this->load->view('pocetna'); ?>
            
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
            
   //onemoguci f5 - refresh 
    document.onkeydown = function() {
        if(event.keyCode == 116) {
                event.returnValue = false;
                event.keyCode = 0;
                return false;
               }
    }
    
   function pocetna()
   { 
       $('.preloader').show();
       $.ajax({
           mimeType: 'text/html; charset=utf-8 general', // ! Need set mimeType only when run from local file
           url: "<?php echo base_url().'administracija/index'; ?>",
           type: 'GET',
           success: function(data) {
               $('#ajax-content').html(data);
               $('.preloader').hide();
           },
           error: function (jqXHR, textStatus, errorThrown) {
               alert(errorThrown);
           },
           dataType: "html",
           async: false
       });
   }
   

   
   function operateri(){
    $('.preloader').show();
    $.ajax({
        mimeType: 'text/html; charset=utf-8 general', // ! Need set mimeType only when run from local file
        url: "<?php echo base_url().'administracija/pregled/operater'; ?>",
        type: 'GET',
        success: function(data) {
            $('#ajax-content').html(data);
            $('.preloader').hide();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        },
        dataType: "html",
        async: false
    });
} 
  
    function partneri(){
    $('.preloader').show();
    $.ajax({
        mimeType: 'text/html; charset=utf-8 general', // ! Need set mimeType only when run from local file
        url: "<?php echo base_url().'administracija/pregled/partner'; ?>",
        type: 'GET',
        success: function(data) {
            $('#ajax-content').html(data);
            $('.preloader').hide();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        },
        dataType: "html",
        async: false
    });
} 

    function artikl(){
    $('.preloader').show();
    $.ajax({
        mimeType: 'text/html; charset=utf-8 general', // ! Need set mimeType only when run from local file
        url: "<?php echo base_url().'administracija/pregled/artikl'; ?>",
        type: 'GET',
        success: function(data) {
            $('#ajax-content').html(data);
            $('.preloader').hide();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        },
        dataType: "html",
        async: false
    });
} 

 
   
   function info()
   {
    
    $('.preloader').show();  

    $.post("<?php echo base_url().'administracija/info'; ?>", function(data) {
        if (data != 'false') { 
            $('#ajax-content').html(data);
            $('.preloader').hide();    
        } else {
            $('.preloader').hide();
        }          
    });
      
   }  
   
   function dokument(that)
   {
       $('.preloader').show();
       
       //id vrste dokumenta
       id = that.value;
       
       $.post("<?php echo site_url().'administracija/pregled/dokument'; ?>", {id:id}, function(data) {
           
           if (data != 'false') {
               $('#ajax-content').html(data);
               $('.preloader').hide();
           }
           else
           {
               $('.preloader').hide();
           }
       }); 
   } 
   
   function korisnici()
   {
       $('.preloader').show();
              
       $.post("<?php echo site_url().'administracija/korisnici'; ?>", function(data) {
           
           if (data != 'false') {
               $('#ajax-content').html(data);
               $('.preloader').hide();
           }
           else
           {
               $('.preloader').hide();
           }
       }); 
   } 
   
   
   function profil(id)
   {
    
    $('.preloader').show();  

    $.post("<?php echo base_url().'profili/uredjivanje/operater'; ?>",{id:id}, function(data) {
        if (data != 'false') { 
            $('#ajax-content').html(data);
            $('.preloader').hide();    
        } else {
             $('.preloader').hide();
        }          
    });
      
   } 
   
   
   function postavke()
   {
    
    $('.preloader').show();  

    $.post("<?php echo base_url().'postavke/pregled'; ?>", function(data) {
        if (data != 'false') { 
            $('#ajax-content').html(data);
            $('.preloader').hide();    
        } else {
            $('.preloader').hide();
        }          
    });
      
   }
   
   
   
   function pregled()
   {
        $('.preloader').show();  

        $.post("<?php echo base_url().'pregled/pregled_dok'; ?>", function(data) {
            if (data != 'false') { 
                $('#ajax-content').html(data);
                $('.preloader').hide();    
            } else {
                $('.preloader').hide();
            }          
        }); 
   }    
   
   function stanje_blagajne()
   {
        $('.preloader').show();  

        $.post("<?php echo base_url().'pregled/stanje_blagajne'; ?>", function(data) {
            if (data != 'false') { 
                $('#ajax-content').html(data);
                $('.preloader').hide();    
            } else {
                $('.preloader').hide();
            }          
        });
   }    
   
   
   function rekapitulacija()
   {
        $('.preloader').show();  

        $.post("<?php echo base_url().'pregled/rekapitulacija'; ?>", function(data) {
            if (data != 'false') { 
                $('#ajax-content').html(data);
                $('.preloader').hide();    
            } else {
                $('.preloader').hide();
            }          
        });
   } 
   
   
   $('.close-link').click(function (event) {       
        CloseModalBox();
    });
    
    
    function resetirajLozinku()
{

    if($("#resetPass").is(":visible"))
     {
        $("#submitLogin").removeClass("hidden"); 
        $("#resetPass").hide(); 
        $("#resetButton").hide(); 
     }
     else
     {
        $("#submitLogin").addClass("hidden");
        $("#resetPass").show(); 
        $("#resetButton").show(); 
 
     }
}


$('#odustani').click(function(evnt){
    evnt.preventDefault();      
    $("#submitLogin").removeClass("hidden"); 
    $("#resetPass").hide(); 
    $("#resetButton").hide();
});
  

$('#resetiraj').click(function(evnt){
    //$('#submitRegister').attr("disabled", true);   
    //posalji novi pass na navedenu email addresu
    //upisani pass mora postojati u bazi
    mail = $('#mail').val();
    
    evnt.preventDefault();
            
    $.post("<?php echo site_url().'registracija/resetPass'; ?>", {mail: mail},
     
    function (data) {
        var obj = $.parseJSON(data);

        if (obj.uspjelo == 0)
        {   
            $('#poruka2').html(obj.poruka); 
            $('#poruka2').removeClass( "hidden" ) 
            $('#poruka2').show(); 
              setTimeout(function() {
                $('#poruka2').fadeOut('fast'); 
                }, 5000);         
        }
        else
        {      
            $('#poruka2').html(obj.poruka); 
            $('#poruka2').removeClass( "hidden" ) 
            $('#poruka2').show(); 
            
            $("#submitLogin").removeClass("hidden"); 
            $("#resetPass").hide(); 
            $("#resetButton").hide(); 
            $("#mail").val('');
            
        }
    });
        

});
   
   
</script>



</body>
</html>       
      
      


  	

        
 
