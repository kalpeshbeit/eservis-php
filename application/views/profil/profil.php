
             <!--Start Breadcrumb-->
             <div class="row">
                <div id="breadcrumb" class="col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url();?>">Po&#269;etna</a></li>  
                        <li><a href="#">Profil</a></li>
                    </ol>
                </div>
             </div>
             <!--End Breadcrumb-->

             
 <div class="row" id="tablica"><!--Poèetak tablice s podacima-->     
    <div class="col-xs-12">
<fieldset>
                  <div class="panel-body">
                  <div id="poruka"><!--Poèetak diva poruke o uspjehu pohrane/izmjene podataka-->
            </div>  <!--Kraj poruke o uspjehu-->
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#osnovno" data-toggle="tab">Korisni&#269;ki profil</a>
                                </li>
                                <li><a href="#pravni" data-toggle="tab">Tvrtka</a>
                                </li>
                                </li>
                            </ul>
<div class="box-content"><!--
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="osnovno">
                                <div id="accordion">
                <h3>Osnovni podaci</h3>
                <div id="profil">
             
            <!--- ovdje poèima forma unos poslovnog prostora--->                       
         <div class="box-content"><!--Poèetak sadržaja forme-->
            <form id="operaterForm" enctype="multipart/form-data" method="post" action="" class="form-horizontal">
                <input id="id" name="id" type="hidden"  value="<?php if(isset($id)){echo $id;} ?>"/>
                <input id="id_operater" name="id" type="hidden"  value="<?php if(isset($id)){echo $id;} ?>"/>
                <fieldset>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Ime</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="ime" name="ime" value="<?php if(isset($id)){echo $object->op_ime;} ?>"/>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Prezime</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="prezime" value="<?php if(isset($id)){echo $object->op_prezime;} ?>"/>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Aktivan</label>
                            <div class="col-sm-3">

                                
                                <select class="form-control" name="aktivan" id="aktivan">
                                    <?php 
                                        $aktivan = array("1","0");
                                        
                                        for($x=0;$x <2;$x++){ ?>
                                            <option value="<?php echo $aktivan[$x]; ?>" <?php if ($aktivan[$x] == @$object->op_aktivan) echo ' selected="selected"'; ?>><?php if($aktivan[$x] == 1) echo 'Da'; else echo 'Ne'; ?></option>       
                                        <?php
                                        }
                                         ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="email" value="<?php if(isset($id)){echo $object->op_mail;} ?>" />
                            </div>
                    </div>
                    <?php if(!isset($id)){ ?>
                     <div class="form-group">
                        <label class="col-sm-3 control-label">Lozinka</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="password" value="<?php if(isset($id)){echo $object->op_lozinka;} ?>" />
                            </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Potvrdi lozinku</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="confirmPassword" value="<?php if(isset($id)){echo $object->op_lozinka;} ?>"/>
                            </div>
                    </div>
                    
                    <?php } ?>
                    
                                        
                    <div class="form-group">
                        <label class="col-sm-3 control-label">OIB</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="oib" value="<?php if(isset($id)){echo $object->op_oib;} ?>" />
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Telefon</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="telefon" value="<?php if(isset($id)){echo $object->op_telefon;} ?>"/>
                            </div>
                    </div>
                      <div class="form-group">  
                    
                    <label class="col-sm-3 control-label">Avatar</label>
                            <div class="col-sm-6">
                                <input name="slika" type="file">
                            </div>
                    </div> 
                    
                    <div class="form-group">   
                    
                      <div class="col-sm-1 col-sm-offset-3 ">    
                            <?php echo $this->session->userdata('slika' )? '<a href="#" title="Ukloni" onclick="brisi(); return false;" ><i class="fa fa-times-circle"></i></a>' : '' ?>
                            <img id="avatar_slika" src="<?php  echo  $this->session->userdata('slika' )? base_url().$this->session->userdata('slika') : base_url().'assets/img/default_avatar.jpg'; ?>" class="img-rounded" alt="avatar" /> 
                        </div>
                      
                    </div>
                    
                </fieldset>
                    <div class="form-group">  
                        <div class="col-sm-offset-3 bs-example">
                            <div class="col-sm-6">
                                <button id="spremi" type="submit" class="btn btn-primary">Spremi</button> 
                            </div>
                        </div>                           
                    </div>
            </form>
        </div>
                   
            </div><!---kraj <div id="fiskalizacija_poslovniProstor">--->
                
                <h3>Promjena lozinke</h3>
                <div id="lozinka">
                  <div class="box-content"><!--Poèetak sadržaja forme-->
            <form id="operaterForm2" method="post" action="" class="form-horizontal">
                <input id="id" name="id" type="hidden"  value="<?php if(isset($id)){echo $id;} ?>"/>
                <fieldset>

                     <div class="form-group">
                        <label class="col-sm-3 control-label">Nova lozinka</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" name="password" placeholder="Unesite lozinku" value="" />
                            </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Potvrdi lozinku</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" name="confirmPassword" placeholder="Potvrdite lozinku" value=""/>
                            </div>
                    </div>            

                </fieldset>
                    <div class="form-group">  
                        <div class="col-sm-3 col-sm-offset-3">
                            <button id="spremi" type="submit" class="btn btn-primary">Spremi</button>
                        </div>
                    </div>
                    
            </form>
        </div>
                </div>
              
            </div>
                                      
                                </div>
                                <div class="tab-pane fade" id="pravni">
                                   
                                                    <div id="lozinka">
                  <div class="box-content"><!--Poèetak sadržaja forme-->
            
            
            <form id="firmaForm" enctype="multipart/form-data" method="post" action="" class="form-horizontal">       
 <fieldset>                  
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Naziv</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control"  name="naziv" value="<?php echo $firma->fi_naziv; ?>"/>
                            </div>                              </div>
                        <div class="form-group"> 
                        <label class="col-sm-2 control-label">Adresa</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="adresa" value="<?php echo $firma->fi_adresa; ?>"/>
                            </div>    </div>
                          <div class="form-group"> 
                        <label class="col-sm-2 control-label">Aktivna</label>
                            <div class="col-sm-3">

                                
                                <select class="form-control" name="aktivan" id="aktivan">
                                    <?php 
                                        $aktivan = array("1","0");
                                        
                                        for($x=0;$x <2;$x++){ ?>
                                            <option value="<?php echo $aktivan[$x]; ?>" <?php if ($aktivan[$x] == @$firma->fi_aktivan) echo ' selected="selected"'; ?>><?php if($aktivan[$x] == 1) echo 'Da'; else echo 'Ne'; ?></option>       
                                        <?php
                                        }
                                         ?>
                                </select>
                            </div>
                        </div>  
                          
                    <div class="form-group"> 
                      <label class="col-sm-2 control-label">OIB</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="oib" value="<?php echo $firma->fi_oib; ?>" />
                            </div>
                    </div>  
                    <div class="form-group">
                    
                        <label class="col-sm-2 control-label">Po&#353;ta</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="posta" value="<?php echo $firma->fi_posta; ?>" />
                            </div>
                    </div>   
                    <div class="form-group"> 
                      <label class="col-sm-2 control-label">Mjesto</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="mjesto" value="<?php echo $firma->fi_mjesto;?>" />
                            </div>
                    </div>                      
                    <div class="form-group"> 
                       <label class="col-sm-2 control-label">Telefon</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="telefon" value="<?php echo $firma->fi_telefon; ?>" />
                            </div>
                    </div>                      
                    <div class="form-group"> 
                     <label class="col-sm-2 control-label">IBAN</label>
                            <div class="col-sm-6">
                                
                                <textarea  name="iban" class="form-control"><?php if(isset($id)){echo $firma->fi_iban;} ?></textarea>
                            </div>
                    </div>  
                    <div class="form-group"> 
                      <label class="col-sm-2 control-label">Fax</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="fax" value="<?php echo $firma->fi_fax; ?>"/>
                            </div>
                    </div>
                    <div class="form-group"> 
                     <label class="col-sm-2 control-label">Mail</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="mail" value="<?php echo $firma->fi_mail; ?>"/>
                            </div>
                    </div>
                    <div class="form-group">
                       <label class="col-sm-2 control-label">Mobitel</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="mobitel" value="<?php echo $firma->fi_mobitel; ?>"/>
                            </div>  
                    </div>
                    <div class="form-group"> 
                     <label class="col-sm-2 control-label">U sustavu PDV.a</label>
                            <div class="col-sm-3">

                                
                                <select class="form-control" name="sustavPDV">
                                    <?php 
                                        $pdv = array("0","1");
                                        
                                        for($x=0;$x <2;$x++){ ?>
                                            <option value="<?php echo $pdv[$x]; ?>" <?php if ($pdv[$x] == @$firma->fi_usustavuPDV) echo ' selected="selected"'; ?>><?php if($pdv[$x] == 1) echo 'Da'; else echo 'Ne'; ?></option>       
                                        <?php
                                        }
                                         ?>
                                </select>
                            </div>
                    </div>
                    
                    <div class="form-group">
                       <label class="col-sm-2 control-label">Opis za podno&#382;je</label>
                            <div class="col-sm-6">
                                 <textarea  placeholder="Registrirano na Trgova&#269;kom sudu...temeljni kapital..." name="opis" class="form-control" rows="5" cols="40"><?php if(isset($id)){echo $firma->fi_opis;} ?></textarea>
                            </div>  
                    </div>
                       
                    
                </fieldset>
                    
                    <div class="form-group">  
                    
                    <label class="col-sm-2 control-label">Logo tvrtke</label>
                            <div class="col-sm-6">
                                <input name="slika_logo" type="file">
                            </div>
                    </div> 
                    
                    <div class="form-group">                              
                        <div class="col-sm-3 col-sm-offset-2">
                            <div>
                            
                                <a id="slika_logo_brisi" <?php  echo $firma->fi_logo?   : 'style="display: none"' ?>  href="#" title="Ukloni" onclick="brisi_logo(); return false;" ><i class="fa fa-times-circle"></i></a>

                                <img id="logo_firme" src="<?php  echo $firma->fi_logo?  base_url().$firma->fi_logo : base_url().'assets/img/default_logo.png'; ?>" class="img-rounded" alt="avatar" />
                            </div>
                        </div>  
                    </div>
                    
                    
                    
                    <div class="form-group">                              
                        <div class="col-sm-3 col-sm-offset-2">
                            <button id="spremi" type="submit" class="btn btn-primary">Spremi</button>
                        </div>
                    </div>
            </form>
        </div>
                </div>
                                </div>
                             
                            </div>
                            </div>
                        </div>
                </fieldset>
                              
    </div><!--- kraj .col 12 --->                                
</div><!--- kraj #tablice --->             
             
<script type="text/javascript">

$(document).ready(function() {

    LoadBootstrapValidatorScript(FormValidator); 

    var icons = {
        header: "ui-icon-circle-arrow-e",
        activeHeader: "ui-icon-circle-arrow-s"
    };
    // Make accordion feature of jQuery-UI
    $("#accordion").accordion({icons: icons });
    
    
    
    
     $('#operaterForm2').submit(function(evnt){

        id = $("#id").val();

        $('#spremi').attr("disabled", true);

        evnt.preventDefault();
      
        $.post("<?php echo site_url().'administracija/change_password/'; ?>",
        
        $("#operaterForm2").serialize(), 
        
            function (data) {
                var obj = $.parseJSON(data);

                if (obj.uspjelo == 0)
                {
                //$('#poruka').html(obj.poruka); 
                //$('#greska').html(obj.greska); 
                }
                else
                {

                    $.post("<?php echo site_url().'profili/uredjivanje/operater'; ?>",{id:id}, function(data) {
                        if (data != 'false') {
                            $('#ajax-content').empty();
                            $('#ajax-content').html(data);
                            $('#poruka').html(obj.poruka);
                            $('#poruka').show();

                            setTimeout(function() {
                            $('#poruka').fadeOut('fast');
                            }, 10000);
                            $('#ajax-content').show();
                        }
                    });  
                }
        });

    });
     
    

    $("#operaterForm").submit(function(event){
        
        id = $("#id").val();
        
        event.preventDefault(); //Prevent Default action. 
        var formObj = $(this);
        var formURL = "<?php echo site_url().'profili/uredjivanjeAction/operater'; ?>";
        var formData = new FormData(this);
    
    $.ajax({
        url: formURL,
        type: 'POST',
        data:  formData,
        mimeType:"multipart/form-data",
        contentType: false,
        cache: false,
        processData:false,
            success: function(data, textStatus, jqXHR)
            {

                 var obj = $.parseJSON(data); 
  
                  if(obj.uspjelo != "0")
                 {

                    $.post("<?php echo site_url().'profili/uredjivanje/operater'; ?>",{id:id}, function(data) {   
                            if (data != 'false') {
                                                                
                                $('#ajax-content').empty();
                                $('#ajax-content').html(data);
                                $('#poruka').html(obj.poruka);
                                $('#poruka').show();

                                setTimeout(function() {
                                $('#poruka').fadeOut('fast');
                                }, 10000);
                                $('#ajax-content').show();   
                                if(obj.slika)
                                {
                                $("#avatar").attr("src",obj.slika);
                                $("#avatar_slika").attr("src",obj.slika);
                                }
                            }
                     });
                 }
                 else
                 {

                     $('#poruka').html(obj.poruka);
                     $('#poruka').show(); 
                     setTimeout(function() {
                        $('#poruka').fadeOut('fast');
                     }, 10000);    
                 }                        
              
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                alert(3); 
                $('#poruka').html("Dogodila se greska! Pokusajte ponovno.");  
            }
            
           
         });   

    }); 


    
    
    $("#firmaForm").submit(function(event){
        
    id = $("#id_operater").val(); 
    
    event.preventDefault(); //Prevent Default action. 
    var formObj = $(this);
    var formURL = "<?php echo site_url().'profili/uredjivanjeAction/firma'; ?>";
    var formData = new FormData(this);
    
    
    $.ajax({
        url: formURL,
        type: 'POST',
        data:  formData,
        mimeType:"multipart/form-data",
        contentType: false,
        cache: false,
        processData:false,
    success: function(data, textStatus, jqXHR)
    {
          var obj = $.parseJSON(data);
          
            $('#poruka').html(obj.poruka);
            $('#poruka').show();

            setTimeout(function() {
            $('#poruka').fadeOut('fast');
            }, 10000);
            
            if(obj.slika)
            {
                $("#logo_firme").attr("src",obj.slika);   
                $("#slika_logo_brisi").show();
            }
    },
        error: function(jqXHR, textStatus, errorThrown) 
            {
                $('#poruka').html("Dogodila se greska! Pokusajte ponovno.");
            }          
        });
    });


    $('.close-link1').click(function (event) {       
        CloseModalBox();
    }); 
     

});



function brisi()
{
    //alert($("#id_odabran").val());
    
    var header = 'Brisanje slike profila';

  
                                             
    var form = $('<div class="form-group"><label">&#381;elite obrisati sliku profila?</label></div>'+
    '<div class="form-group">'+
    '<button id="delete" type="delete" onclick="obrisiAvatar()" class="btn btn-danger btn-label-left">'+
                        '<span><i class="fa fa-trash-o"></i></span>'+
                        'Obri&#353;i</button>'+' '+                       
                        '<button id="cancel" onclick="cancel()" class="btn btn-default btn-label-left">'+
                        '<span><i class="fa fa-reply txt-danger"></i></span>'+
                        'Odustani'+
                        '</button></div>'   
    );
        
    OpenModalBox(header, form);
}

function brisi_logo()
{
    //alert($("#id_odabran").val());
    
    var header = 'Brisanje loga tvrtke';
                                 

    var form = $('<div class="form-group"><label">&#381;elite obrisati logo tvrtke?</label></div>'+
    '<div class="form-group">'+
    '<button id="delete" type="delete" onclick="obrisiLogo()" class="btn btn-danger btn-label-left">'+
                        '<span><i class="fa fa-trash-o"></i></span>'+
                        'Obri&#353;i</button>'+' '+                       
                        '<button id="cancel" onclick="cancel()" class="btn btn-default btn-label-left">'+
                        '<span><i class="fa fa-reply txt-danger"></i></span>'+
                        'Odustani'+
                        '</button></div>'   
    );
        
    OpenModalBox(header, form);
}


function cancel()
{
    CloseModalBox();
}


function obrisiAvatar()
{
     id = $("#id_operater").val();
       
     $.post("<?php echo site_url().'profili/brisanje_avatar/operater'; ?>", {id:id}, function(data) {
           
     if (data != 'false') {
              
              var obj = $.parseJSON(data);
          
             $.post("<?php echo site_url().'profili/uredjivanje/operater'; ?>",{id:id}, function(data) {
                    if (data != 'false') {
                        
                            $('#ajax-content').empty();
                            $('#ajax-content').html(data);
                            $('#poruka').html(obj.poruka);
                            $('#poruka').show();
                            CloseModalBox();
                            
                            setTimeout(function() {
                                $('#poruka').fadeOut('fast');
                            }, 10000);
                            
                            $('#ajax-content').show();
                            $("#avatar").attr("src",obj.slika);
                            $("#avatar_slika").attr("src",obj.slika);
                        }
                    });  
           }
     });  
} 


function obrisiLogo()
{
     $.post("<?php echo site_url().'profili/brisanje_logo/firma'; ?>", function(data) {
           
         if (data != 'false') {
             
             var obj = $.parseJSON(data);
                  
             $('#poruka').html(obj.poruka);
             CloseModalBox();
                
             setTimeout(function() {
                $('#poruka').fadeOut('fast');
             }, 10000);
                                                           
                
             $("#logo_firme").attr("src",obj.slika);
             $("#slika_logo_brisi").hide();  
         }
     });  
} 
     
</script>
        