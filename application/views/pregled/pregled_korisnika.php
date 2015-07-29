        

<div class="row">
                <div id="breadcrumb" class="col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url();?>">Po&#269;etna</a></li>
                        <li><a href="#">Administracija</a></li>   
                        <li><a href="#">Pregled</a></li>
                    </ol>
                </div>
             </div>
             <!--End Breadcrumb-->
             
             
             
<!---<div class="row show-grid-forms">
                <div class="col-sm-4">
                    <h3 class="page-header">Artikli</h3>
                </div>                
</div>--->

<div id="forma" class="row" style="display: none;"> <!--PoËetak div.a od forme za unos koji je unutar ajax-content div.a-->
            </div> <!--Kraj diva forme zaunos-->            
            
            
            
<div class="row" id="tablica"><!--PoËetak tablice s podacima-->     
    <div class="col-xs-12">
         <div id="poruka"><!--PoËetak diva poruke o uspjehu pohrane/izmjene podataka-->
            </div>  <!--Kraj poruke o uspjehu-->
        <div class="box">
       
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-barcode"></i>
                    <span>Korisnici aplikacije</span>
                    
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content no-padding">
                <table class="table table-bordered table-striped table-heading table-datatable" id="datatable-33">
                    <thead>
                        <tr>
                            <th>Naziv</th>
                            <th class="hidden-xs hidden-sm">Oib</th>
                            <th>Datum registracije</th>
                            <th>Registriran do</th>
                            <th class="hidden-xs hidden-sm">U sustavu PDV-a</th>
                            <th>Izdano racuna</th>
                            <th>Izdano ponuda</th>
                            <th>Racun korisnika</th>
                            <th class="hidden-xs hidden-sm">Email</th>
                            <th class="hidden-xs hidden-sm">Mobitel</th>
                            <th class="hidden-xs hidden-sm">Telefon</th> 
                        </tr>
                    </thead>
                    <tbody>
                    <!-- Start: list_row -->
                        <?php 

                            $rank = 0; foreach ($table as $firma) {?>
                                <tr class="oddrow clickable">
                                    <td><?php echo $firma->fi_naziv; ?></td>
                                    <td class="hidden-xs hidden-sm"><?php echo $firma->fi_oib; ?></td>
                                    <td><?php echo isset($firma->fi_datumregistracije)? date("d.m.Y. H:i:s", strtotime($firma->fi_datumregistracije)):''; ?></td>
                                    <td><?php echo isset($firma->fi_registracijado)? date("d.m.Y. H:i:s", strtotime($firma->fi_registracijado)):''; ?></td>
                                    <td class="hidden-xs hidden-sm"><?php if( $firma->fi_usustavuPDV == 1) echo "Da"; else echo "Ne"; ?></td>
                                    <td><?php echo $firma->racun; ?></td>
                                    <td><?php echo $firma->ponuda; ?></td>
                                    <td><?php echo $firma->fi_iban; ?></td>
                                    <td class="hidden-xs hidden-sm"><?php echo $firma->fi_mail; ?></td>
                                    <td class="hidden-xs hidden-sm"><?php echo $firma->fi_mobitel; ?></td>
                                    <td class="hidden-xs hidden-sm"><?php echo $firma->fi_telefon; ?></td>  
                                </tr>
                                
                            <?php } ?>
                        
                    <!-- End: list_row -->
                    </tbody>
                </table>
               
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
// Run Datables plugin and create 3 variants of settings


$(document).ready(function() {
    // Load Datatables and run plugin on tables 
    LoadDataTablesScripts(AllTables);
     
    $(".clickable").click(function() { 

        $(".clickable").removeClass("active"); 
        $(this).addClass("active");     
        $('#detalji').prop("disabled", false);  
    });
  
    $('#datatable-33 tr').click(function (event) {       
          $("#id_odabran").val($(this).attr('id'));
    });
     
    $('.close-link').click(function (event) {       
        CloseModalBox();
    });

});



function AllTables(){
    TestTable33();
        
    $('.dataTables_filter').each(function(){
        $(this).find('label input[type=search]').attr('placeholder', 'Pretra≈æi');   
        $(this).find('label input[type=text]').attr('placeholder', 'Pretra≈æi');
    });
    
    
    $(".dataTables_filter").append('<button id="detalji" disabled="disabled" class="btn btn-default btn-label-left" onclick="detalji();" ><span><i class="fa fa-pencil fa-fw"/></span>Detalji</button>&nbsp');
    $('#datatable-3 tbody tr:eq(0)').click(); 
}




function cancel()
{
    CloseModalBox();
}


function detalji()
{
    /*
    id = $("#id_odabran").val();
    
    $('#tablica').hide();


    $.post("<?php echo site_url().'administracija/uredjivanje/artikl'; ?>", {id:id}, function(data) {
        if (data != 'false') {
            $('#forma').empty();
            $('#forma').html(data);
            $('#forma').show();
        } else {
        }
    });    */
}



</script>