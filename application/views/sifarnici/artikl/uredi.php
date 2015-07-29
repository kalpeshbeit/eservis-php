 <!--Poèetak #forma div.a-->
 
<div class="col-xs-12 col-sm-12">
    <div class="box">
        <div class="box-header"><!--Poèetak headera forme-->
            <div class="box-name">
                <i class="fa fa-barcode"></i>
                <span><?php if(isset($id)){echo "Uredi artikl";} else {echo "Dodaj artikl";} ?></span>
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
            <form id="artiklForm" method="post" action="" class="form-horizontal">
            
                <input id="id" name="id" type="hidden"  value="<?php if(isset($id)){echo $id;} ?>"/>
                 <p><?php if ($this->session->userdata('UsustavuPDV') == 0): ?>
                    <div class="alert alert-danger">
                        Tvrtka nije u sustavu PDV.a, bez obzira na stopu pojedinog artikla PDV se nece obracunavati!
                    </div>
                 <?php endif; ?></p>
                  
                <fieldset>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">&#352;ifra artikla</label>
                            <div class="col-sm-3"> 
                                <input <?php if(isset($id)){echo 'readonly="readonly"';} ?> type="text" class="form-control" name="sifra" value="<?php if(isset($id)){echo $object->ar_sifra;} ?>"/>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Naziv artikla</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="naziv" value="<?php if(isset($id)){echo $object->ar_naziv;} ?>"/>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Aktivan</label>
                            <div class="col-sm-2">

                                
                                <select class="form-control" name="aktivan">
                                    <?php 
                                        $aktivan = array("1","0");
                                        
                                        for($x=0;$x <2;$x++){ ?>
                                            <option value="<?php echo $aktivan[$x]; ?>" <?php if ($aktivan[$x] == @$object->ar_aktivan) echo ' selected="selected"'; ?>><?php if($aktivan[$x] == 1) echo 'Da'; else echo 'Ne'; ?></option>       
                                        <?php
                                        }
                                         ?>
                                </select>
                            </div>
                    </div>                  
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Vrsta artikla</label>
                            <div class="col-sm-3">

                                
                                <select class="form-control" name="usluga">
                                    <?php 
                                        $usluga = array("0","1");
                                        
                                        for($x=0;$x <2;$x++){ ?>
                                            <option value="<?php echo $usluga[$x]; ?>" <?php if ($usluga[$x] == @$object->ar_usluga) echo ' selected="selected"'; ?>><?php if($usluga[$x] == 1) echo 'Usluga'; else echo 'Roba'; ?></option>       
                                        <?php
                                        }
                                         ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group">
                            <?php if($this->session->userdata('UsustavuPDV') == 1){ ?>
                                <label class="col-sm-3 control-label">Cijena (bez PDV.a)</label>
                            <?php }else {?>                  
                                <label class="col-sm-3 control-label">Cijena</label>
                            <?php    
                            } ?>
                        
                            <div class="col-sm-2">
                                <input type="text" onpaste="return false;" onkeydown="provjeri(this);" class="form-control" name="cijena" value="<?php if(isset($id)){echo $object->ar_malopcijena;} ?>" />
                            </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="col-sm-3 control-label">Porezna stopa</label>
                            <div class="col-sm-2">
                                 <select class="form-control" name="porez">
                                 <?php foreach ($porezi as $v){    ?>
                                 <option value="<?php echo $v->pz_ID; ?>" <?php if(isset($id)){if($v->pz_ID==$object->porez_pz_id){ ?> selected="selected" <?php }} ?>><?php echo $v->pzs_naziv; ?></option>
                                                             
                                 <?php } ?>
                                </select>
                            </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jedinica mjere</label>
                            <div class="col-sm-2">
                                 <select class="form-control" name="jedinica">
                                 <?php foreach ($mjere as $v){    ?>
                                 <option value="<?php echo $v->jm_sifra; ?>" <?php if(isset($id)){if($v->jm_sifra==$object->JedinicaMjere_jm_sifra){ ?> selected="selected" <?php }} ?>><?php echo $v->jm_sifra; ?></option>
                                                             
                                 <?php } ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Serijski broj</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="serijski" value="<?php if(isset($id)){echo $object->ar_serijskibroj;} ?>"/>
                            </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Opis</label>
                            <div class="col-sm-6">

                                <textarea name="opis" class="form-control" rows="5" cols="40"><?php if(isset($id)){echo $object->ar_opis;} ?></textarea>
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
          document.getElementById("artiklForm").reset();  

          $('#forma').hide();
     }); 
     
     
      $('#artiklForm').submit(function(evnt){
          
      //$('#spremi').attr("disabled", true);

          
        evnt.preventDefault();
        $.post("<?php echo site_url().'administracija/process_form/artikl'; ?>",
        $("#artiklForm").serialize(), 
        function (data) {
            var obj = $.parseJSON(data);

            if (obj.uspjelo == 0)
            {
                $('#poruka').html(obj.poruka); 
                $('#poruka').removeClass( "hidden" ) 
                $('#poruka').show(); 
                  setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                    }, 5000);
               
            }
            else
            {
                $.post("<?php echo site_url().'administracija/vrati/artikl'; ?>", function(data) {
                    if (data != 'false') {
                    $('#ajax-content').empty();
                    $('#ajax-content').html(data);
                    $('#poruka').html(obj.poruka);

                    setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                    }, 5000);
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