 <!--Poèetak #forma div.a-->
             
            <form id="naplatniuredajForm" method="post" action="">

                <input id="id" name="id" type="hidden"  value="<?php if(isset($id)){echo $id;} ?>"/>
                
                <fieldset>
                
                <div class="form-group">
                    <label class="control-label">Poslovni prostor</label>
                    <select class="form-control" name="poslovniprostor" <?php echo isset($id)? 'disabled="disabled"' : '' ?>>
                    <?php foreach ($prodajnomjesto as $v){    ?>
                    <option value="<?php echo $v->pm_id; ?>" <?php if(isset($id)){if($v->pm_id==$object->prodajnoMjesto_pm_id){ ?> selected="selected" <?php }} ?>><?php echo $v->pm_oznaka; ?></option>
                    <?php } ?>
                    </select> 
                </div>
                
                <div class="form-group">
                    <label class="control-label">Oznaka naplatnog ure&#273;aja</label>
                    <input type="text" class="form-control" id="naplatniuredjaj" name="naplatniuredjaj" placeholder="Oznaka ure&#273;aja" value="<?php if(isset($id)){echo $object->nu_broj;} ?>"/>
                </div>
                  
                </fieldset>
                
                <div class="form-group">  
                    <button id="spremi" type="submit" class="btn btn-primary">Spremi</button> 
                    <button type="reset" class="btn btn-default close-link1">Odustani</button>
                </div>
              
            </form>
                
                
<script type="text/javascript">
$(document).ready(function() {  
    
     LoadBootstrapValidatorScript(FormValidator); 
     
      $('#naplatniuredajForm').submit(function(evnt){
      
      $('#spremi').attr("disabled", true);
      $('select').removeAttr('disabled');
      
      
      
      evnt.preventDefault();
      
      $.post("<?php echo site_url().'administracija/process_form/naplatniuredjaj'; ?>",
      
      $("#naplatniuredajForm").serialize(), 
      
        function (data) {
            var obj = $.parseJSON(data);

            if (obj.uspjelo == 0)
            {
                  /*$('#poruka').html(obj.poruka); 
                  $('#poruka').removeClass( "hidden" ) 
                  $('#poruka').show(); 
                  setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                  }, 10000);  */
            }
            else
            {
 
                $.post("<?php echo site_url().'postavke/pregled'; ?>", function(data) {
                    if (data != 'false') {
                    $('#ajax-content').empty();
                    $('#ajax-content').html(data);
                    $('#poruka').html(obj.poruka);
                    $("#accordion").accordion({ active: 1});
                    setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                    }, 5000);
                    $('#ajax-content').show();
                    CloseModalBox();    
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
