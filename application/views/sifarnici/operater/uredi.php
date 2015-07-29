 <!--Poèetak #forma div.a-->
 
<div class="col-xs-12 col-sm-12">
    <div class="box">
        <div class="box-header"><!--Poèetak headera forme-->
            <div class="box-name">
                <i class="fa fa-user"></i>
                <span><?php if(isset($id)){echo "Uredi operatera";} else {echo "Dodaj operatera";} ?></span>
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
            <form id="operaterForm" method="post" action="" class="form-horizontal">
                <input id="id" name="id" type="hidden"  value="<?php if(isset($id)){echo $id;} ?>"/>
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
                                <input type="text" class="form-control" name="email" value="<?php echo isset($id)? $object->op_mail: '' ?>" />
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
        
    //LoadBootstrapValidatorScript(FormValidator); 

     
    $('.close-link1').click(function (event) {       
          $('#tablica').show();
          document.getElementById("operaterForm").reset();  

          $('#forma').hide();
     }); 
     
     
      $('#operaterForm').submit(function(evnt){
          
      //$('#spremi').attr("disabled", true);
      
        evnt.preventDefault();
        $.post("<?php echo site_url().'administracija/process_form/operater'; ?>",
        $("#operaterForm").serialize(),
        function (data) {
            
            var obj = $.parseJSON(data);

            if (obj.uspjelo == 0)
            {
                $('#poruka').html(obj.poruka); 
                $('#poruka').removeClass( "hidden" ) 
                $('#poruka').show(); 
                  setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                    }, 10000);
            }
            else
            {
                $.post("<?php echo site_url().'administracija/vrati/operater'; ?>", function(data) {
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

});

</script>