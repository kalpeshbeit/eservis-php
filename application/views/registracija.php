   
<!--Start Breadcrumb-->
<div class="row">
    <div id="breadcrumb" class="col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Po&#269;etna</a></li>
            <li><a href="">Registracija</a></li>
        </ol>
    </div>
</div>
        
<!--End Breadcrumb-->
<div class="row">
 <div class="col-xs-12">  
        <h3 class="page-header">Registracija korisnika</h3>
    </div> 
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12"> 
     
        <div class="box">        
            <div class="alert alert-info">    
                Dobrodo&#353;li <b><?php echo $korisnik->op_ime;?></b> ! &nbsp;&nbsp;&nbsp;&nbsp;<br/>
                Popunite  forme s potrebnim  podacima o Va&#353;oj tvrtki i spremni ste za rad!
            </div>                  
        </div>  
     
    </div> 
</div>  



<!--Start Dashboard 1-->
<div class="row">
    <div class="col-xs-12">

        <div class="panel-body">
            <div id="poruka"><!--Poèetak diva poruke o uspjehu pohrane/izmjene podataka-->
            </div>  <!--Kraj poruke o uspjehu-->
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">

            <li  class="active"><a id="tvrtka" href="#pravni" data-toggle="tab">Detalji o tvrtki</a>
            </li>
            <li ><a id="korisnik" href="#osnovno" data-toggle="tab">Va&#353; korisni&#269;ki profil</a>
            </li>

            </ul>  
       
            <div class="box-content"> 
                <div class="tab-content">  

                    <div class="tab-pane fade in active" id="pravni">
                    
                        <div class="box-content">
                          
                            <form id="firmaFormRegister" method="post" action="" class="form-horizontal">       
                                <fieldset>                  
                                <input id="id_firma" name="id" type="hidden"  value=""/>     
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Naziv</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control"  name="naziv" value=""/>
                                    </div>                              
                                </div>
                                <div class="form-group"> 
                                    <label class="col-sm-2 control-label">Adresa</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="adresa" value=""/>
                                    </div>    
                                </div> 
                                <div class="form-group"> 
                                    <label class="col-sm-2 control-label">Mjesto</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="mjesto" value="" />
                                    </div>
                                </div>                      
                                <div class="form-group">

                                    <label class="col-sm-2 control-label">Po&#353;ta</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="posta" value="" />
                                    </div>
                                </div>   

                                <div class="form-group"> 
                                    <label class="col-sm-2 control-label">OIB</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="oib" value="" />
                                    </div>
                                </div>  

                                <div class="form-group"> 
                                    <label class="col-sm-2 control-label">IBAN</label>
                                    <div class="col-sm-6">
                                        <textarea  name="iban" class="form-control"></textarea>
                                    </div>
                                </div>  

                                <div class="form-group"> 
                                    <label class="col-sm-2 control-label">Mail</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="mail" value="<?php echo $korisnik->op_mail; ?>"/>
                                    </div>
                                </div>

                                <div class="form-group"> 
                                    <label class="col-sm-2 control-label">U sustavu PDV.a</label>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="sustavPDV">
                                            <?php 
                                            $pdv = array("1","0");

                                            for($x=0;$x <2;$x++){ ?>
                                            <option value="<?php echo $pdv[$x]; ?>" ><?php if($pdv[$x] == 1) echo 'Da'; else echo 'Ne'; ?></option>       
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Opis za podno&#382;je ra&#269;una</label>
                                    <div class="col-sm-6">
                                        <textarea  placeholder="Registrirano na Trgova&#269;kom sudu...temeljni kapital..." name="opis" class="form-control" rows="5" cols="40"></textarea>
                                    </div>  
                                </div>

                                <div class="form-group">                              
                                    <div class="col-sm-3 col-sm-offset-2">
                                        <button id="spremi" type="submit" class="btn btn-primary">Dalje >></button>
                                    </div>
                                </div>  
                                </fieldset>                
                            </form> 
                        </div>

                    </div>
                    <div class="tab-pane fade" id="osnovno">
                        <div class="box-content">  
                        <div id="poruka2"><!--Poèetak diva poruke o uspjehu pohrane/izmjene podataka-->
                             </div>  <!--Kraj poruke o uspjehu--> 
                            <form id="operaterForm" enctype="multipart/form-data" method="post" action="" class="form-horizontal">
                                <input type="hidden" name="password" id="password" class="form-control" value="<?php echo $korisnik->op_lozinka; ?>" />                      
                                <input id="id_operater" name="id" type="hidden"  value="<?php echo $korisnik->op_id; ?>"/>
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Ime</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="ime" name="ime" value="<?php echo $korisnik->op_ime; ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Prezime</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="prezime" value="<?php echo $korisnik->op_prezime; ?>"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="email" value="<?php echo $korisnik->op_mail; ?>" />
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">OIB</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="oib" value="<?php echo $korisnik->op_oib; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Telefon</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="telefon" value="<?php echo $korisnik->op_telefon; ?>"/>
                                        </div>
                                    </div>

                                    <div class="form-group">  
                                        <div class="col-sm-offset-2 bs-example">
                                            <div class="col-sm-6">
                                                <button id="spremi" type="submit" class="btn btn-primary">Spremi</button> 
                                            </div>
                                        </div>                           
                                    </div>
                                </fieldset>  
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        
        </div>
    
    </div><!--- kraj .col 12 --->                                

</div>
    <form id="formLogin" action='<?php echo base_url(); ?>stranica/login_nakon_registracije' class="form-signin" method=POST>
        <input type="hidden" name="email" id="email" class="form-control" value="<?php echo $korisnik->op_mail; ?>" />
        <input type="hidden" name="password" id="password" class="form-control" value="<?php echo $korisnik->op_lozinka; ?>" />                      
    </form>


<script type="text/javascript">    
// Run Datables plugin and create 3 variants of settings


$(document).ready(function() {  
     
    $('#firmaFormRegister').submit(function(evnt){
  
      $('#spremi').attr("disabled", true);
      
        evnt.preventDefault();
        $.post("<?php echo site_url().'registracija/process_form/firma'; ?>",
        $("#firmaFormRegister").serialize(),
        function (data) {
            
            var obj = $.parseJSON(data);

            if (obj.uspjelo == 0)
            {
                $('#poruka').html(obj.poruka);
                $('#poruka').show();
                setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                }, 10000);
            }
            else
            {
                //spremi id koji smo dohvatili od spremljene fime
                $('#id_firma').val(obj.id);
                $('#poruka').html(obj.poruka);
                $('#poruka').show();
                setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                }, 10000);
                //prebaci focus na tab 2
                $('#korisnik').trigger('click');     
                                      
                    
            }
        });

    });
    
    
    
      $('#operaterForm').submit(function(evnt){
         id = $('#id_firma').val();
        
        if(id)
        {
              $('#spremi').attr("disabled", true);
              
                evnt.preventDefault();
                $.post("<?php echo site_url().'registracija/process_form/operater'; ?>",
                $("#operaterForm").serialize() + '&id_firma=' + id,
                function (data) {
                    
                    var obj = $.parseJSON(data);

                    if (obj.uspjelo == 0)
                    {
                        $('#poruka2').html(obj.poruka);
                        $('#poruka2').show();
                        setTimeout(function() {
                            $('#poruka2').fadeOut('fast');
                        }, 10000);
                    }
                    else
                    {
                        //spremi id koji smo dohvatili od spremljene fime
                       
                        $('#poruka2').html(obj.poruka);
                        $('#poruka2').show();
                        setTimeout(function() {
                            $('#poruka2').fadeOut('fast');
                        }, 10000);
             

                        $('#password').val(obj.email);

                      //logiraj korisnika ako je sve uspješno  submit fome 
                        $('#formLogin').submit();                      
                            
                    }
                });
        }
        else
        {
            $('#tvrtka').trigger('click');
            
            $('#poruka').html('<pre class="bg-warning">Prvo popunite detalje o tvrtki!</pre>');
            $('#poruka').show();
            setTimeout(function() {
                $('#poruka').fadeOut('fast');
            }, 10000);
        }
    });
    
    
});        
    


</script>


