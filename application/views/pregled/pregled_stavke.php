  <?php if (!empty($table)) {  ?>                 
 <script type="text/javascript" language="javascript" class="init">


$(document).ready(function() { 
           
       $('#example').dataTable( { 
     
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '.')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                } );
                     
            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                } );

            // Update footer
            $( api.column( 4 ).footer() ).html(  
                accounting.formatMoney(pageTotal)+' kn ('+ accounting.formatMoney(total) +' kn ukupno)'
            );  
        },
        "aaSorting": [[ 0, "desc" ]],
        //"bSort" : false,
        "sDom": 'T<"clear">lrtip',  
        
        //"<'hidden-xs hidden-sm'T><'box-content'<'col-sm-6'f><'col-sm-6 text-right'l><'clearfix'>>rt<'box-content'<'col-sm-6'i><'col-sm-6 text-right'p><'clearfix'>>",   
        "oLanguage": {
            "sSearch": "",
            "sLengthMenu": 'Prikaži _MENU_ rezultata'
        },
        "oTableTools": {
            "sSwfPath": "assets/plugins/datatables/copy_csv_xls_pdf.swf",
            "aButtons": [ 
                //"copy",
                //"print",
                "xls",
                {
                    "sExtends": "pdf",
                    "sTitle": "Pregled dokumenata"
                },
                //"csv"
                /*{
                    "sExtends":    "collection",
                    "sButtonText": 'Spremi <span class="caret" />',
                    "aButtons":    [  "xls", "pdf", "csv" ]
                }*/
            ]
        }            
    } );
    
    
} );
 
                  <?php   
                        } ?>     

</script>
                     
    <div class="col-xs-12">

        <div class="box">
          
            <div class="box-header">   
                <div class="box-name">
                    <i class="fa fa-barcode"></i>
                    <span>Rezultat</span>
                    
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
            
            <div class="box-content "> 
              
                 <table id="example" class="display table table-heading table-datatable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                            <th>Dokument broj</th> 
                            <th>Tvrtka</th>                       
                            <th>Datum izrade</th>
                            <th>Iznos</th>
                            <th class="hidden-xs">Djelatnik</th>     
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                    <th></th> 
                    <th></th> 
                    <th></th> 
                    <th  style="text-align:right">Ukupno:</th>
                    <th>0.00</th>
                    </tr>
                </tfoot>

                <tbody>
                
                    <?php if (!empty($table)) {  ?>   
                         <?php 

                          $rank = 0; foreach ($table as $dokument) {?>
                                <tr >
                                    <td><?php echo $dokument->do_broj; ?></td>
                                    <td><?php if($dokument->partner) {echo $dokument->partner;} else {echo $dokument->pa_naziv;} ?></td>
                                    <td><?php echo isset($dokument->do_datum)? date("d.m.Y.", strtotime($dokument->do_datum)):''; ?></td>
                                    <td><?php echo  number_format((float)$dokument->do_iznos + $dokument->do_iznosPDV, 2, ',','') ?></td>
                                    <td class="hidden-xs"><?php echo $dokument->operater; ?></td>      
                                </tr>                                
                            <?php } ?>
                        <?php }else{ ?>
                            
                            <tr id="nemastavki">
                                <td style="text-align: center;" colspan="5">Nemate dokumenata koji odgovaraju upitu</td>
                               
                            </tr>
                            
                         <?php   
                        } ?>     
                       

                </tbody> 
            </table>
                 <input id="id_odabran" type="hidden"  value=""/>
                 
                
            </div>
        </div>   
    </div>
                                                                                          

           
  
    