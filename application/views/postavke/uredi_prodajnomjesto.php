 <!--Poèetak #forma div.a-->
            <div id="poruka2"></div> 
            <form class="form-horizontal"  id="poslovniprostorForm" method="post" action="">

                <input id="id" name="id" type="hidden"  value="<?php if(isset($id)){echo $id;} ?>"/>
                
                <fieldset> 
                <div class="form-group"> 
                    <label class="col-sm-6 control-label">Oznaka poslovnog prostora</label>
                    <div class="col-sm-6">        
                        <input type="text" class="form-control" <?php if(isset($object->pm_datumRegistracije)){echo 'readonly="readonly"';} ?>  name="poslovniprostor" placeholder="Oznaka prostora"   value="<?php if(isset($id)){echo $object->pm_oznaka;} ?>"/>
                    </div>
                    </div>
                <div class="form-group"> 
                    <label class="col-sm-6 control-label">OIB</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" <?php if(isset($object->pm_datumRegistracije)){echo 'readonly="readonly"';} ?>  name="oib" placeholder="Oib"   value="<?php if(isset($id)){echo $object->pm_oib;} ?>"/>
                    </div>
                    </div>
                

                <div class="form-group"> 
                    <label class=" col-sm-6 control-label">Ulica</label>
                     <div class="col-sm-6">
                    <input type="text" class="form-control" name="ulica" placeholder="Ulica" value="<?php if(isset($id)){echo $object->pm_ulica;} ?>"/>
                    </div>
                    </div>
                    
                <div class="form-group"> 
                    <label class=" col-sm-6 control-label">Ku&#263;ni broj</label>
                     <div class="col-sm-6">
                    <input type="text" class="form-control" name="kucniBroj" placeholder="Ku&#263;ni broj" value="<?php if(isset($id)){echo $object->pm_kucniBroj;} ?>"/>
                    </div>
                    </div>
                             
                <div class="form-group"> 
                    <label class="col-sm-6  control-label">Dodatak ku&#263;nom broju</label>
                     <div class="col-sm-6">
                    <input type="text" class="form-control" name="kucniBrojDodatak" placeholder="Dodatak ku&#263;nom broju" value="<?php if(isset($id)){echo $object->pm_kucniBrojDodatak;} ?>"/>
                    </div>
                    </div>
                <div class="form-group"> 
                    <label class="col-sm-6 control-label">Broj po&#353;te</label>
                     <div class="col-sm-6">
                    <input type="text" class="form-control" name="posta" placeholder="Broj po&#353;te" value="<?php if(isset($id)){echo $object->pm_posta;} ?>"/>
                    </div>
                    </div>
                <div class="form-group"> 
                    <label class="col-sm-6 control-label">Op&#263;ina</label>
                     <div class="col-sm-6">
                    <input type="text" class="form-control" name="opcina" placeholder="Op&#263;ina" value="<?php if(isset($id)){echo $object->pm_opcina;} ?>"/>
                    </div>
                    </div>
                <div class="form-group"> 
                    <label class="col-sm-6 control-label">Mjesto</label>
                     <div class="col-sm-6">
                    <input type="text" class="form-control" name="mjesto" placeholder="Mjesto" value="<?php if(isset($id)){echo $object->pm_mjesto;} ?>"/>
                    </div>
                    </div>
                <div class="form-group"> 
                    <label class="col-sm-6 control-label">Ostali tipovi PP</label>
                     <div class="col-sm-6">
                    <input type="text" class="form-control" name="ostaliTipovi" placeholder="pokretna trgovina..." value="<?php if(isset($id)){echo $object->pm_ostaliTipovi;} ?>"/>
                    </div>
                    </div>
                <div class="form-group"> 
                    <label class="col-sm-6 control-label">Radno vrijeme</label>
                     <div class="col-sm-6">
                    <input type="text" class="form-control" name="radnoVrijeme" placeholder="Radno vrijeme" value="<?php if(isset($id)){echo $object->pm_radnoVrijeme;} ?>"/>
                    </div>
                    </div>
                <div class="form-group has-feedback"> 
                    <label class="col-sm-6 control-label">Datum po&#269;etka primjene</label>
                     <div class="col-sm-6">
                    <input type="text" id="datumPocetkaPrimjene" class="form-control" name="datumPocetkaPrimjene" placeholder="npr. 01.01.2014." value="<?php echo isset($id)? date("d.m.Y.", strtotime($object->pm_datumPocetkaPrimjene)): date("d.m.Y."); ?>"/>
                    <span class="fa fa-calendar form-control-feedback"/>
                    </div>
                    </div>
                <div class="form-group"> 
                    <label class="col-sm-6 control-label">Oznaka zatvaranja<label class="txt-danger">**</label>  </label>  
                     <div class="col-sm-6">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" <?php  if(isset($id)) {if($object->pm_oznakaZatvaranja == "Z"){echo 'checked="checked"';}} ?> value="Z" id="oznakaZatvaranja" name="oznakaZatvaranja"/>
                                    <i class="fa fa-square-o"/>
                                </label>
                             </div>
                        </div>
                    </div>
                    
                <div class="form-group"> 
                    <label class="col-sm-6 control-label">OIB proizvo&#273;a&#269;a softvera</label>
                     <div class="col-sm-6">
                    <input type="text" class="form-control" name="oibProizvodjaca" readonly="readonly" placeholder="" value="<?php  echo (isset($oibProizvodjaca)) ? $oibProizvodjaca->mf_oib : '' ?>"/>
                    </div>
                    </div>
                <!---
                <div class="form-group has-feedback"> 
                    <label class="col-sm-6 control-label">Datum registracije</label>
                     <div class="col-sm-6">
                    <input type="text" id ="datumRegistracije" class="form-control" name="datumRegistracije" placeholder="Datum registracije" value="<?php if(isset($id)){echo isset($object->pm_datumRegistracije)? date("d.m.Y.", strtotime($object->pm_datumRegistracije)):'';} ?>"/> <span class="fa fa-calendar form-control-feedback"/>
                    </div>
                </div>
                --->
                
                </fieldset>
                
                <div class="form-group"> 
                  <div class="col-sm-6  col-sm-offset-6"> 
                    <button id="spremi" type="submit" class="btn btn-primary">Spremi</button> 
                    <button type="reset" class="btn btn-default close-link1">Odustani</button>
                </div>
                </div>
              
            </form>
           <p  class="txt-danger"><em>** odabrati jedino u slu&#269;aju trajnog zatvaranja poslovnog prostora!!</em></p>
                            
<script type="text/javascript">

$(document).ready(function() {  


    $('#datumPocetkaPrimjene,#datumRegistracije').datepicker($.extend({
      showMonthAfterYear: false,
      dateFormat:'d MM, y',
      changeMonth: true,
      changeYear: true, 
      yearRange: '-60:+10',
      autoclose: true,
      showButtonPanel: true
    },
    $.datepicker.regional['hr']
  ));  
            
    LoadBootstrapValidatorScript(FormValidator); 
     
    $('#poslovniprostorForm').submit(function(evnt){
        
        $('#spremi').attr("disabled", true);
            evnt.preventDefault();
            $.post("<?php echo site_url().'administracija/process_form/prodajnomjesto'; ?>",
            $("#poslovniprostorForm").serialize(), 
            
            function (data) {
                var obj = $.parseJSON(data);
                
                if (obj.uspjelo == 0)
                {     
                    $('#poruka2').html(obj.poruka); 
                    $('#poruka2').show(); 
                      setTimeout(function() {
                        $('#poruka2').fadeOut('fast');
                        }, 10000);  
                    //$('#greska').html(obj.greska); 
                }
                else
                {
                    $.post("<?php echo site_url().'postavke/pregled'; ?>", function(data) {
                        if (data != 'false') {
                        $('#ajax-content').empty();
                        $('#ajax-content').html(data);                      
                        $('#ajax-content').show(); 
                        CloseModalBox();   
                        
                        $('#poruka').html(obj.poruka); 
                        $('#poruka').removeClass( "hidden" )  
                        $('#poruka').show();
                        setTimeout(function() {
                        $('#poruka').fadeOut('fast');
                        }, 10000);   
                        }   
                    });  
                }
            });
    });
    
    
    $('.close-link1').click(function (event) {       
        CloseModalBox();
    }); 
    
});

</script>
