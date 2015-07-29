 <!--Poèetak #forma div.a-->
 
<div class="col-xs-12 col-sm-12">
    <div class="box">
        <div class="box-header"><!--Poèetak headera forme-->
            <div class="box-name">
                <i class="fa fa-chain"></i>
                <span><?php if(isset($id)){echo "Uredi partnera";} else {echo "Dodaj partnera";} ?></span>
            </div>
            <div class="box-icons">
                <a class="close-link1">
                <i class="fa fa-times"></i>
                </a>
            </div>
            <div class="no-move"></div>
        </div><!--Kraj headera forme-->
        
        <div class="box-content"><!--Poèetak sadržaja forme-->
           <div id="poruka" class="hidden"><!--Poèetak diva poruke o uspjehu pohrane/izmjene podataka-->
            </div>  <!--Kraj poruke o uspjehu-->
            <form id="partnerForm" method="post" action="" class="form-horizontal">
                <input id="id" name="id" type="hidden"  value="<?php if(isset($id)){echo $id;} ?>"/>
                
                <fieldset>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Naziv partnera</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="naziv" value="<?php if(isset($id)){echo $object->pa_naziv;} ?>"/>
                            </div>
                    </div>   
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Mjesto</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="mjesto" value="<?php if(isset($id)){echo $object->pa_mjesto;} ?>"/>
                            </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Adresa</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="adresa" value="<?php if(isset($id)){echo $object->pa_adresa;} ?>"/>
                            </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Po&#353;ta</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="posta" value="<?php if(isset($id)){echo $object->pa_posta;} ?>"/>
                            </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Telefon</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="telefon" value="<?php if(isset($id)){echo $object->pa_telefon;} ?>"/>
                            </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Web stranica</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="web" value="<?php if(isset($id)){echo $object->pa_web;} ?>"/>
                            </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="mail" value="<?php if(isset($id)){echo $object->pa_mail;} ?>"/>
                            </div>
                    </div>        
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Fax</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="fax" value="<?php if(isset($id)){echo $object->pa_fax;} ?>"/>
                            </div>
                    </div>        
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Oib</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="oib" value="<?php if(isset($id)){echo $object->pa_oib;} ?>"/>
                            </div>
                    </div> 
                    
                     <div class="form-group">
                        <label class="col-sm-3 control-label">U sustavu PDV.a</label>
                            <div class="col-sm-2">

                                
                                <select class="form-control" name="sustavPDV">
                                    <?php 
                                        $pdv = array("0","1");
                                        
                                        for($x=0;$x <2;$x++){ ?>
                                            <option value="<?php echo $pdv[$x]; ?>" <?php if ($pdv[$x] == @$object->pa_usustavupdv) echo ' selected="selected"'; ?>><?php if($pdv[$x] == 1) echo 'Da'; else echo 'Ne'; ?></option>       
                                        <?php
                                        }
                                         ?>
                                </select>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">&#381;iro ra&#269;un</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="ziro" value="<?php if(isset($id)){echo $object->pa_ziroracun;} ?>"/>
                            </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Mati&#269;i broj</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="maticni" value="<?php if(isset($id)){echo $object->pa_maticnibr;} ?>"/>
                            </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Aktivan</label>
                            <div class="col-sm-2">

                                
                                <select class="form-control" name="aktivan">
                                    <?php 
                                        $aktivan = array("1","0");
                                        
                                        for($x=0;$x <2;$x++){ ?>
                                            <option value="<?php echo $aktivan[$x]; ?>" <?php if ($aktivan[$x] == @$object->pa_aktivan) echo ' selected="selected"'; ?>><?php if($aktivan[$x] == 1) echo 'Da'; else echo 'Ne'; ?></option>       
                                        <?php
                                        }
                                         ?>
                                </select>
                            </div>
                    </div> 
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Opaska</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="opaska" value="<?php if(isset($id)){echo $object->pa_opaska;} ?>"/>
                            </div>
                    </div>                 

                    
                </fieldset>
                    <div class="form-group">  
                        <div class="col-sm-offset-3 bs-example">
                            <div class="col-sm-6">
                                <button id="spremi" type="submit" class="btn btn-primary">Spremi</button> 
                                <button type="reset" class="btn btn-default close-link1">Odustani</button>
                            </div>
                        </div>                           
                    </div>
            </form>
        </div><!--kraj sadržaja forme-->
    </div> <!--kraj box-->
</div>

<!--Kraj #forma div.a-->

<script type="text/javascript">
$(document).ready(function() {
        
    LoadBootstrapValidatorScript(FormValidator); 

     
    $('.close-link1').click(function (event) {       
          $('#tablica').show();
          document.getElementById("partnerForm").reset();  

          $('#forma').hide();
     }); 
     
     
      $('#partnerForm').submit(function(evnt){
          
      $('#spremi').attr("disabled", true);

          
        evnt.preventDefault();
        $.post("<?php echo site_url().'administracija/process_form/partner'; ?>",
        $("#partnerForm").serialize(), 
        function (data) {
            var obj = $.parseJSON(data);

            if (obj.uspjelo == 0)
            {
                //$('#poruka').html(obj.poruka); 
                //$('#greska').html(obj.greska); 
            }
            else
            {
                $.post("<?php echo site_url().'administracija/vrati/partner'; ?>", function(data) {
                    if (data != 'false') {
                    $('#ajax-content').empty();
                    $('#ajax-content').html(data);
                    $('#poruka').html(obj.poruka);

                    setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                    }, 10000);
                    $('#ajax-content').show();
                    }
                });  
            }
        });

    });

});


function provjeri(that)
{
   if (that.value.indexOf(",") >= 0) {
    that.value = that.value.replace(/\,/g,".");
    }
    
}

</script>