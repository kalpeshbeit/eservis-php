 
<link rel="stylesheet" type="text/css" href="assets/media/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="assets/media/css/dataTables.tableTools.css">


<script type="text/javascript" language="javascript" src="assets/js/accounting.js"></script> 
<script type="text/javascript" language="javascript" src="assets/media/js/jquery.dataTables.js"></script> 
<script type="text/javascript" language="javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript" language="javascript" src="assets/plugins/datatables/TableTools.js"></script>
<script type="text/javascript" language="javascript" src="assets/plugins/datatables/ZeroClipboard.js"></script>
    

        

<script type="text/javascript" language="javascript" class="init">


$(document).ready(function() { 
   
   LoadBootstrapValidatorScript(FormValidator); 
    
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
        $(this).find('label input[type=search]').attr('placeholder', 'Pretra≈æi');   
        $(this).find('label input[type=text]').attr('placeholder', 'Pretra≈æi');
    }); 
    
    
      LoadSelect2Script(DemoSelect2);  
              
 
} );


function DemoSelect2(){
    //$('#poslovni_prostor').select2({placeholder: "Odaberite"});
    //$('#s2_country').select2(); 
    $('#poslovni_prostor').select2({ placeholder: "Poslovnica", minimumResultsForSearch: -1});
    $('#naplatni_uredjaj').select2({ placeholder: "Blagajna", minimumResultsForSearch: -1});
    $('#nacin_placanja').select2({ placeholder: "Vrsta placanja", minimumResultsForSearch: -1});
                         

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
    $('#naplatni_uredjaj').select2('val', '');    
    $('#nacin_placanja').select2('val', '');    

});




function dohvatiNaplatniUredjaj(that,idUredjaja)
    {
        id = that.value;
       //alert(id); 
       
         $.post("<?php echo site_url().'dokument/prikaziNaplatniUredjaj'; ?>",{id:id, iduredjaja:idUredjaja}, function(data) {
                if (data != 'false') {
                    $("#naplatni_uredjaj").empty();
                    $("#naplatni_uredjaj").html(data);

                    //selektiram prvi zapis u svim select 2 objektima pa moram maknut search sa 3 linije ispod
                    //$('select').select2();
                    
                    $('#naplatni_uredjaj').select2({ minimumResultsForSearch: -1, placeholder: "odaberi"});
                    
                    //selektirati ispravni ID ovisno o ID.u NU dokumenta 
                    //$("#naplatni_uredjaj").val(idUredjaja).trigger("change");   
                         

  
                }
             });  
                  
    }
    
    
$('#pregledStanjeForm').submit(function(evnt){
      
            
    evnt.preventDefault();
    
    vpID = $("#nacin_placanja").val();

    datOD = $("#datumOD").val();
    datDO = $("#datumDO").val();
    pmID = $("#poslovni_prostor").val();
    nuID = $("#naplatni_uredjaj").val();
     
     if(pmID != "" && nuID != "" && vpID != "")
     {
        $('#report').attr('src', "<?php echo site_url(); ?>pregled/pdf/"+datOD+'/'+datDO+'/'+pmID+'/'+nuID+'/'+vpID);
        $('#pdf').show();    
        $('#pregled').hide();     
     }
     else if(pmID != "" && nuID != "" && vpID == "")
     {
           $('#report').attr('src', "<?php echo site_url(); ?>pregled/pdf/"+datOD+'/'+datDO+'/'+pmID+'/'+nuID);
           $('#pdf').show();    
           $('#pregled').hide(); 
     }  

}); 


$('.close-link1').click(function (event) {       
        //vrati pocetni popis svih dokumenata

        $('#pdf').hide();
        $('#pregled').show();

});   



</script>       

  <div class="row">
    <div id="breadcrumb" class="col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Po&#269;etna</a></li> 
            <li><a href="#">Pregled</a></li>
            <li><a href="#">Stanje blagajne</a></li>
        </ol>
    </div>
</div>
<div class="row" id="pregled">
   <div id="poruka"><!--PoËetak diva poruke o uspjehu pohrane/izmjene podataka-->
            </div>  <!--Kraj poruke o uspjehu-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
<div class="well">
    
    <h4 class="page-header">Pregled stanja blagajne</h4><br/>     
        
        <form class="form-horizontal" id="pregledStanjeForm" role="form">                      
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
              
                <div class="form-group  has-feedback">
                    <label class="col-sm-3 control-label">Prodajno mjesto / blagajna</label>
                     <div class="col-sm-6">    
                     <table>
                                <tr>
                                    <td> 
       
                                         <select id="poslovni_prostor" name="poslovni_prostor" onchange="dohvatiNaplatniUredjaj(this <?php echo isset($id)? ",".$object->naplatniuredjaj_nu_id :''; ?>)">
                                             <option></option>       
                                            <?php foreach ($prodajnamjesta as $v){    ?>  
                                                <option value="<?php echo $v->pm_id; ?>" <?php if(isset($id)){if($v->pm_id==$object->prodajnoMjesto_pm_id){ ?> selected="selected" <?php }} ?>><?php echo $v->pm_oznaka; ?></option>
                                            <?php } ?>
                                         </select>                       
                                    </td>
                                    <td>&nbsp/&nbsp</td> 
                                    <td>
                                        <select  id="naplatni_uredjaj" name="naplatni_uredjaj" >       
                                            <!--- ovdje se puni vanjskom skriptom---> 
                                            <option></option>    
                                        </select>
                                    </td> 
                                </tr>
                            </table> 
                   
                   </div>  
                </div>  
                   <div class="form-group"> 
 
                        <label class="col-sm-3 control-label" for ="nacin_placanja">Na&#269;in pla&#263;anja</label>
  
                            <div class="col-sm-4">                                
                                 <select id="nacin_placanja" name="nacin_placanja">
                                  <option></option>       
                                    <?php foreach ($sredstvoplacanja as $v){    ?>
                                        <option value="<?php echo $v->sp_id; ?>" <?php if(isset($id)){if($v->sp_id==$object->sredstvoplacanja_sp_id){ ?> selected="selected" <?php }} ?>><?php echo $v->sp_opis; ?></option>
                                    <?php } ?>
                                </select>
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

            
<div class="row" id="pdf" style="display: none;">
  <div class="col-xs-12 col-sm-12">
    <div class="box">
        <div class="box-header"><!--PoËetak headera forme-->
            <div class="box-name">
                <i class="fa fa-file-text"></i>
                <span>Pregled stanja</span>
            </div>
            <div class="box-icons">
                <a class="close-link1">
                <i class="fa fa-times"></i>
                </a>
            </div>
            <div class="no-move"></div>
        </div><!--Kraj headera forme-->

        <div class="box-content" ><!--PoËetak sadrûaja forme-->
                                                                                                                                                
        <iframe id="report" name="report" src="" style="width:100%; height: 800px;" frameborder="0"></iframe>

        </div>
    </div> <!--kraj box-->  


</div>
</div>



