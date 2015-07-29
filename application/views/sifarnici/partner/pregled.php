        

<div class="row">
                <div id="breadcrumb" class="col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url();?>">Po&#269;etna</a></li>
                        <li><a href="#">&#352;ifarnici</a></li>   
                        <li><a href="#">Partneri</a></li>
                    </ol>
                </div>
             </div>
             <!--End Breadcrumb-->
             
             
             
             <!--<div class="row show-grid-forms">
                <div class="col-sm-4">
                    <h3 class="page-header">Partneri</h3>
                </div>                
             </div>-->
    
    <div id="forma" class="row" style="display: none;"> <!--PoËetak div.a od forme za unos koji je unutar ajax-content div.a-->
            </div> <!--Kraj diva forme zaunos-->     
            
                    
<div class="row" id="tablica"><!--PoËetak tablice s podacima-->   
    <div class="col-xs-12">
       <div id="poruka"><!--PoËetak diva poruke o uspjehu pohrane/izmjene podataka-->
            </div>  <!--Kraj poruke o uspjehu-->
        <div class="box">
         
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-chain"></i>
                    <span>Partneri</span>
                    
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
                <table class="table table-bordered table-striped table-heading table-datatable" id="datatable-3">
                    <thead>
                        <tr>
                            <th class="id-th hidden-xs hidden-sm"><i class="fa fa-tag icon-white hidden-xs hidden-sm"></i></th>
                            <th>Naziv</th>
                            <th>Mjesto</th>
                            <th class="hidden-xs hidden-sm">Telefon</th>
                            <th>Email</th>
                            <th class="hidden-xs hidden-sm">OIB</th>
                            <th class="hidden-xs hidden-sm">&#381;iro</th>
                            <th class="hidden-xs hidden-sm">Aktivan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!-- Start: list_row -->
                        <?php 

                            $rank = 0; foreach ($table as $partner) {?>
                                <tr class="oddrow clickable" id="<?php echo $partner->pa_id; ?>">
                                    <td class="id-td hidden-xs hidden-sm"><?php echo ++$rank; ?></td>
                                    <td><?php echo $partner->pa_naziv; ?></td>
                                    <td><?php echo $partner->pa_mjesto; ?></td>
                                    <td class="hidden-xs hidden-sm"><?php echo $partner->pa_telefon; ?></td>
                                    <td><?php echo $partner->pa_mail; ?></td>
                                    <td class="hidden-xs hidden-sm"><?php echo $partner->pa_oib; ?></td>
                                    <td class="hidden-xs hidden-sm"><?php echo $partner->pa_ziroracun; ?></td>
                                    <td class="hidden-xs hidden-sm"><?php if($partner->pa_aktivan == 1) echo "Da"; else echo "Ne"; ?></td>
                                </tr>
                                
                            <?php } ?>
                        
                    <!-- End: list_row -->
                    </tbody>
                </table>
                 <input id="id_odabran" type="hidden"  value=""/>
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
        $('#dodaj').prop("disabled", false);
        $('#uredi').prop("disabled", false);
  });
  
    $('#datatable-3 tr').click(function (event) {       
          $("#id_odabran").val($(this).attr('id'));
     }); 
     
     $('.close-link').click(function (event) {       
        CloseModalBox();
     });
});



function AllTables(){
    TestTable3();
    
    $('.dataTables_filter').each(function(){
        $(this).find('label input[type=search]').attr('placeholder', 'Pretra≈æi');   
        $(this).find('label input[type=text]').attr('placeholder', 'Pretra≈æi');
    });
    
    $(".dataTables_filter").append('<button class="btn btn-default btn-label-left" onclick="dodaj();" ><span><i class="fa fa-pencil fa-fw"/></span>Dodaj</button>&nbsp');
    $(".dataTables_filter").append('<button id="uredi" disabled="disabled" class="btn btn-default btn-label-left" onclick="uredi();" ><span><i class="fa fa-edit fa-fw"/></span>Uredi</button>&nbsp');
    $(".dataTables_filter").append('<button id="dodaj" disabled="disabled" class="btn btn-default btn-label-left" onclick="brisi();" ><span><i class="fa fa-trash-o fa-fw"/></span>Bri&#353;i</button>');
    $('#datatable-3 tbody tr:eq(0)').click(); 
}

function brisi()
{
    //alert($("#id_odabran").val());
    
    var header = 'Brisanje partnera';
                                             
    var form = $('<div class="form-group"><label">&#381;elite obrisati odabranog partnera?</label></div>'+
    '<div class="form-group">'+
    '<button id="delete" type="delete" onclick="obrisi()" class="btn btn-danger btn-label-left">'+
                        '<span><i class="fa fa-trash-o"></i></span>'+
                        'Obri&#353;i</button>'+' '+                       
                        '<button id="cancel" onclick="cancel()" class="btn btn-default btn-label-left">'+
                        '<span><i class="fa fa-reply txt-danger"></i></span>'+
                        'Odustani'+
                        '</button></div>');
        
    OpenModalBox(header, form);
}

function obrisi()
{
    id = $("#id_odabran").val();
    
    $.post("<?php echo site_url().'administracija/brisanje/partner'; ?>", {id:id}, function(data) {
        if (data != 'false') {
            var obj = $.parseJSON(data);
            
           $.post("<?php echo site_url().'administracija/vrati/partner'; ?>", function(data) {
                    if (data != 'false') {
                    $('#ajax-content').empty();
                    $('#ajax-content').html(data);
                    $('#poruka').html(obj.poruka);
                     $('#ajax-content').show();
                    
                     CloseModalBox();
                    }
                    
                    setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                    }, 10000);
                   
                });  
        }
    }); 
}

function dodaj()
{
    $('#tablica').hide();

    $.post("<?php echo site_url().'administracija/dodaj/partner'; ?>", function(data) {
        if (data != 'false') {
            $('#forma').empty();
            $('#forma').html(data);
            $('#forma').show();
        } else {
        }
    });  
}

function cancel()
{
    CloseModalBox();
}


function uredi()
{
    id = $("#id_odabran").val();
    
    $('#tablica').hide();


    $.post("<?php echo site_url().'administracija/uredjivanje/partner'; ?>", {id:id}, function(data) {
        if (data != 'false') {
            $('#forma').empty();
            $('#forma').html(data);
            $('#forma').show();
        } else {
        }
    });
}



</script>
