
<link rel="stylesheet" type="text/css" href="assets/media/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="assets/media/css/dataTables.tableTools.css">


<script type="text/javascript" language="javascript" src="assets/js/accounting.js"></script> 
<script type="text/javascript" language="javascript" src="assets/media/js/jquery.dataTables.js"></script> 
<script type="text/javascript" language="javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript" language="javascript" src="assets/plugins/datatables/TableTools.js"></script>
<script type="text/javascript" language="javascript" src="assets/plugins/datatables/ZeroClipboard.js"></script>
    

        

<script type="text/javascript" language="javascript" class="init">


$(document).ready(function() { 
    
    $('#datumOD, #datumDO').datepicker($.extend({
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
  
  
    var currentTime = new Date();
    // First Date Of the month 
    var startDateFrom = new Date(currentTime.getFullYear(),currentTime.getMonth(),1);
    $( "#datumOD" ).datepicker( "setDate", startDateFrom );

    // Last Date Of the Month 
    var startDateTo = new Date(currentTime.getFullYear(),currentTime.getMonth() +1,0);
    $( "#datumDO" ).datepicker( "setDate", startDateTo ); 
    
    
    
    $('.dataTables_filter').each(function(){
        $(this).find('label input[type=search]').attr('placeholder', 'Pretraži');   
        $(this).find('label input[type=text]').attr('placeholder', 'Pretraži');
    }); 
    
    
      LoadSelect2Script(DemoSelect2);      
 
} );


function DemoSelect2(){
    //$('#poslovni_prostor').select2({placeholder: "Odaberite"});
    //$('#s2_country').select2(); 
    $('#poslovni_prostor').select2({minimumResultsForSearch: -1});
                         

}

$('#odustani').click(function(evnt){
    evnt.preventDefault();
          
          
    var currentTime = new Date();
    // First Date Of the month 
    var startDateFrom = new Date(currentTime.getFullYear(),currentTime.getMonth(),1);
    $( "#datumOD" ).datepicker( "setDate", startDateFrom );

    // Last Date Of the Month 
    var startDateTo = new Date(currentTime.getFullYear(),currentTime.getMonth() +1,0);
    $( "#datumDO" ).datepicker( "setDate", startDateTo );
    
   
    $('#poslovni_prostor').select2('val', '');    

});

$('#prikazi').click(function(evnt){
    
    evnt.preventDefault(); 

    if (document.getElementById('racun').checked) {
     
        id = document.getElementById('racun').value;
    }
    else
    {
        id = document.getElementById('ponuda').value;
    }
     
     $.post("<?php echo site_url().'pregled/prikazi'; ?>", 
                
     $("#pregledForm").serialize()+ '&id=' + id,
                
     function(data) { 
        if (data != 'false') {
            $('#tablica').empty();
            $('#tablica').html(data); 
        }
     });
          

});





</script>
    
    
<div class="row">
    <div id="breadcrumb" class="col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Po&#269;etna</a></li> 
            <li><a href="#">Pregled</a></li>
            <li><a href="#">Dokumenata</a></li>
        </ol>
    </div>
</div>
<div class="row">
  <div class="col-xs-12">  
    <div id="poruka">
    </div> 
  </div> 
   
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">  
         
        <div class="well"> 
            <h4 class="page-header">Pregled dokumenata</h4><br/>    

            <form class="form-horizontal" id="pregledForm" role="form">                      
                <div class="form-group has-feedback">
                    <label class="col-sm-3 control-label">Datum od</label>
                    <div class="col-sm-4">
                       <input type="text" id="datumOD" class="form-control" name="datumOD" placeholder="npr. 01.01.2014." value="<?php echo isset($id)? date("d.m.Y.", strtotime($object->do_datum)): date("d.m.Y."); ?>" />
                       <span class="fa fa-calendar form-control-feedback"/>

                    </div>
                     <label class="col-sm-1 control-label">do</label>    
                    <div class="col-sm-4">  
                        <input type="text" id="datumDO" class="form-control" name="datumDO" placeholder="npr. 01.01.2014." value="" />
                       <span class="fa fa-calendar form-control-feedback"/>

                    </div>
               
                </div>
                <!--
                <div class="form-group  has-feedback">
                    <label class="col-sm-3 control-label">Prodajno mjesto</label>
                    <div class="col-sm-6">
                         <select id="poslovni_prostor" name="poslovni_prostor">
                         <option value="">-- Odaberite prodajno mjesto --</option>      
                            <?php foreach ($prodajnamjesta as $v){    ?>  
                                <option value="<?php echo $v->pm_id; ?>" <?php if(isset($id)){if($v->pm_id==$object->prodajnoMjesto_pm_id){ ?> selected="selected" <?php }} ?>><?php echo $v->pm_oznaka; ?></option>
                            <?php } ?>
                         </select>                       
                    </div>                       
                </div>
                 --->
                 <div class="form-group"> 
                        <label class="col-sm-3 control-label" for ="nacin_placanja">Vrsta dokumenta</label>
                            <div class="col-sm-6">
                                <div class="radio-inline">
                                    <label>
                                    <input type="radio" name="radio-inline" checked="" id="racun" value="2"/>
                                    Ra&#269;un  
                                    <i class="fa fa-circle-o"/>
                                    </label>
                                    </div>
                                    <div class="radio-inline">
                                    <label>
                                    <input type="radio" name="radio-inline" id="ponuda" value="1"/>
                                    Ponuda
                                    <i class="fa fa-circle-o"/>
                                    </label>
                                    </div>                                
                              
                            </div>     
                 </div><br/> 

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">                        
                        <button id="prikazi" type="submit" class="btn btn-primary btn-label-left"><span><i class="fa fa-search"/></span>Prikazi</button>
                        <button id="odustani" type="reset" class="btn btn-default close-link1">Odustani</button>
                    </div>
                </div>

            </form>
        </div>     
    </div>     
</div>     
            
<div class="row" id="tablica"><!--Po�etak tablice s podacima-->     
       
</div>   
                                                                                                 
 