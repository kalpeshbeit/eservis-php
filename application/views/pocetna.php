  
<!--Start Breadcrumb-->
<div class="row">
    <div id="breadcrumb" class="col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>stranica">Home</a></li>
            <li><a href="<?php echo base_url();?>">Po&#269;etna</a></li>
        </ol>
    </div>
</div>
        
<!--End Breadcrumb-->    
  

<div id="dashboard-header" class="row">
    <div class="col-xs-12 col-sm-2">
          <h3 class="page-header">Trenutne statisitke</h3>       
    </div>

    <div class="clearfix visible-xs"></div>
    <div class="col-xs-12 col-sm-8 col-md-7">
        <div class="row">
            <div class="col-xs-4">
                <div class="sparkline-dashboard" id="sparkline-1"></div>
                <div class="sparkline-dashboard-info">
                    <b><?php echo $statistike->racuni;?></b>
                    <span class="txt-primary">UKUPNO RA&#268;UNA</span>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="sparkline-dashboard" id="sparkline-2"></div>
                <div class="sparkline-dashboard-info">
                    <b><?php echo $statistike->ponude;?></b>    
                    <span class="txt-info">UKUPNO PONUDA</span>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="sparkline-dashboard" id="sparkline-3"></div>
                <div class="sparkline-dashboard-info">
                    <b><?php echo $statistike->neplaceniracuni;?></b>    
                    <span>NEPLA&#262;ENIH RA&#268;UNA</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="forma" class="row" style="display: none;"/></div>

<div class="row">
    <div class="col-xs-12 col-sm-6"> 
    <div id="poruka"></div>     
       <?php if ($this->session->userdata('UsustavuPDV') == 1 && $nefiskalizirani > 0): ?>
        <div class="box">        
            <div class="alert alert-danger">    
                Imate nefiskaliziranih ra&#269;una!!. Ukupno <b><?php if($nefiskalizirani > 0){echo $nefiskalizirani;}else{echo'';}; ?></b> ! &nbsp;&nbsp;&nbsp;&nbsp;<button style="margin-bottom: 0;" id="delete" type="delete" onclick="fiskalizirajSve()" class="btn btn-danger btn-label-left">Fiskaliziraj</button>
            </div>                  
        </div>  
        <?php endif; ?> 
        
       <?php if ($this->session->userdata('UsustavuPDV') == 1 && $nefiskalizirani == 0): ?>
        <div class="box">        
            <div class="alert alert-info">    
                Nemate nefiskaliziranih ra&#269;una!! &nbsp;&nbsp;&nbsp;&nbsp;
            </div>                  
        </div>  
        <?php endif; ?>     
    </div>
    <div class="col-xs-12 col-sm-6">   
    <!-- ako je trenutni datum + 15 dana > od datuma registracijeDO ne ispisuje se ništa -->  
        <?php
     
            if(floor((strtotime($this->session->userdata('licencaVrijediDo')) - strtotime(date('Y-m-d')))/ (60*60*24))  < 15 && floor((strtotime($this->session->userdata('licencaVrijediDo')) - strtotime(date('Y-m-d')))/ (60*60*24)) >= 0)
            { 
                     
                ?> 
                     <div class="box">        
                        <div class="alert alert-danger">    
                            Licenca programa Vam istje&#269;e <b> <?php echo date("d.m.Y.", strtotime( $this->session->userdata('licencaVrijediDo'))); ?></b> ! Ukoliko je ve&#263; niste dobili, zatra&#382;ite ponudu za produljenje kori&#353;tenja softvera.  &nbsp;&nbsp;&nbsp;&nbsp;
                        </div>                  
                     </div>     
                <?php
            //echo 'Licenca vam vrijedi jo&#353; <b>' .floor((abs(strtotime($this->session->userdata('licencaVrijediDo')) - strtotime(date('Y-m-d'))))/ (60*60*24)) .'</b> dana';                                                         
            }
            else if(floor((strtotime($this->session->userdata('licencaVrijediDo')) - strtotime(date('Y-m-d')))/ (60*60*24) < 0))
            { ?>
                <div class="box">        
                    <div class="alert alert-danger">    
                        Licenca programa Vam je istekla dana <b> <?php echo date("d.m.Y.", strtotime( $this->session->userdata('licencaVrijediDo'))); ?></b> ! Ukoliko &#382;elite i dalje koristiti aplikaciju zatra&#382;ite ponudu za produljenje kori&#353;tenja.  &nbsp;&nbsp;&nbsp;&nbsp;
                    </div>                  
                </div>     
            <?php    
            }
        ?>
       
    </div>
    <div class="col-sm-12">
        <?php
        $rank = 0; foreach ($vrstedokumenta as $dok) {?>  
             <button id="spremi<?php echo ++$rank; ?>" type="submit" onclick="noviRacunRonuda(<?php echo  $dok->vd_id; ?>)" class="btn btn-primary">Izradi <?php if($dok->vd_oznaka == "racun"){echo $this->lang->line('racun');}else{echo $this->lang->line('ponuda');}?> </button>                     
        
        <?php } ?>

    </div> 
    
</div>  

<div class="row">
    <div class="col-xs-12 col-sm-6">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-search"></i>
                    <span>Suma iznosa ra&#269;una zadnjih mjesec dana</span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="expand-link">
                        <i class="fa fa-expand"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">  
                <div id="xchart-1" style="height: 200px; width: 100%;"></div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-search"></i>
                    <span>Najprodavaniji artikli (top 5)</span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="expand-link">
                        <i class="fa fa-expand"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <div id="xchart-2" style="height: 200px;"></div>
            </div>
        </div>
    </div>
</div> 

<!--Start Dashboard 1-->
<div id="dashboard-header" class="row">
    
    
    <div class="col-xs-12 col-sm-6">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-table"></i>
                    <span>Nepla&#263;eni ra&#269;uni</span>
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
            <div class="box-content"> 

                <table class="table table-hover">   

                    <thead>
                        <tr>
                            <th>Broj ra&#269;una</th>
                            <th>Datum</th>
                            <th>Partner</th>
                            <th>Iznos</th>
                            <th>Rok pla&#263;anja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if (!empty($neplaceni)) {
                             foreach ($neplaceni as $dokument) {?>
                                <tr class="oddrow clickable">
                                    <td><?php echo $dokument->do_broj;?></td>        
                                    <td><?php echo isset($dokument->do_datum)? date("d.m.Y.", strtotime($dokument->do_datum)):''; ?></td>
                                    <td><?php echo $dokument->pa_naziv; ?></td>
                                    <td><?php if ($dokument->do_status == "S") {echo '-'. number_format((float)$dokument->do_iznos + $dokument->do_iznosPDV, 2, '.', '');} else {echo number_format((float)$dokument->do_iznos + $dokument->do_iznosPDV, 2, '.', '');} ?></td>
                                    <td><?php echo isset($dokument->do_valuta)? date("d.m.Y.", strtotime($dokument->do_valuta)):''; ?></td>

                                </tr>                                
                             <?php }}else{
                                ?>
                                
                                <tr>
                                    <td style="text-align: center; border-bottom: solid 1px;" colspan="9">Nemate stavki</td>
                                </tr>
                                
                            <?php    
                            } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
     <div class="col-xs-12 col-sm-6">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-table"></i>
                    <span>Nezavr&#353;eni ra&#269;uni</span>
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
            <div class="box-content">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Partner</th>
                            <th>Iznos</th>
                            <th>Operater</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php 
                         if (!empty($nezavrseni)) {
                            foreach ($nezavrseni as $dokument) {?>
                                <tr>  
                                    <td><?php echo isset($dokument->do_datum)? date("d.m.Y.", strtotime($dokument->do_datum)):''; ?></td>
                                    <td><?php echo $dokument->pa_naziv; ?></td>
                                    <td><?php if ($dokument->do_status == "S") {echo '-'. number_format((float)$dokument->do_iznos + $dokument->do_iznosPDV, 2, '.', '');} else {echo number_format((float)$dokument->do_iznos + $dokument->do_iznosPDV, 2, '.', '');} ?></td>
                                    <td><?php echo $dokument->operater;?></td>   
                                </tr>                                
                            <?php }}else{
                                ?>
                                
                                <tr>
                                    <td style="text-align: center; border-bottom: solid 1px;" colspan="9">Nemate stavki</td>
                                </tr>
                                
                            <?php    
                            } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-xs-12 col-sm-6">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-table"></i>
                    <span>Otvorene ponude</span>
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
            <div class="box-content">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Broj ponude</th>
                            <th>Datum</th>
                            <th>Partner</th>
                            <th>Iznos</th>
                            <th>Vrijedo do</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                            if (!empty($ponudeOtvorene)) {
                             foreach ($ponudeOtvorene as $dokument) {?>
                                <tr>
                                    <td><?php echo $dokument->do_broj;?></td>        
                                    <td><?php echo isset($dokument->do_datum)? date("d.m.Y.", strtotime($dokument->do_datum)):''; ?></td>
                                    <td><?php echo $dokument->pa_naziv; ?></td>
                                    <td><?php if ($dokument->do_status == "S") {echo '-'. number_format((float)$dokument->do_iznos + $dokument->do_iznosPDV, 2, '.', '');} else {echo number_format((float)$dokument->do_iznos + $dokument->do_iznosPDV, 2, '.', '');} ?></td>
                                    <td><?php echo isset($dokument->do_valuta)? date("d.m.Y.", strtotime($dokument->do_valuta)):''; ?></td>

                                </tr>                                
                             <?php }}else{
                                ?>
                                
                                <tr>
                                    <td style="text-align: center; border-bottom: solid 1px;" colspan="9">Nemate stavki</td>
                                </tr>
                                
                            <?php    
                            } ?>
                    </tbody>
                </table>  
            </div>
        </div>  
    </div>
  
</div>



<script type="text/javascript">    
// Run Datables plugin and create 3 variants of settings

var sparkline_arr_1 = SparklineTestData();
var sparkline_arr_2 = SparklineTestData();
var sparkline_arr_3 = SparklineTestData();
    
function DrawAllxCharts(){
    xGraph1();
    xGraph2();
}

function xGraph1(){
    var tt = document.createElement('div'),
    leftOffset = -(~~$('html').css('padding-left').replace('px', '') + ~~$('body').css('margin-left').replace('px', '')),
    topOffset = -32;
    tt.className = 'ex-tooltip';
    document.body.appendChild(tt);
    var data = {
        "xScale": "time",
        "yScale": "linear",
        "main": [
            {
            "className": ".xchart-class-1",
            "data": [
                    <?php 
                        if($sumePoDanima){
                    
                    
                    
                    foreach ($sumePoDanima as $v){    ?>          
                             {
                               x: '<?php echo $v->datum; ?>', 
                              
                               y: parseFloat('<?php echo $v->suma; ?>', 2)    
                             },                                     
                    <?php }      
                    }else
                    { ?>
                    
                    
                          {
                          "x": "2013-01-01",
                          "y": -2
                          } ,
                          {
                          "x": "2014-01-01",
                          "y": -1
                          },
                          {
                          "x": "2015-01-01",
                          "y": 0
                          }
                                
                            
                    <?php } ?>
            ] 
            }
        ]
    };
       
  
    var opts = {
        "dataFormatX": function (x) { return d3.time.format('%Y-%m-%d').parse(x); },
        "tickFormatX": function (x) { return d3.time.format('%A')(x); },
        "mouseover": function (d, i) {
            var pos = $(this).offset();
            $(tt).text(d3.time.format("%d.%m.%Y")(d.x) + ' : ' + d.y +' kn')
                .css({top: topOffset + pos.top, left: pos.left + leftOffset})
                .show();
        },
        "mouseout": function (x) {
            $(tt).hide();
        }
    };                                                                     
    var myChart = new xChart('line-dotted', data, '#xchart-1', opts);
}

   
function xGraph2(){
    var tt = document.createElement('div'),
    leftOffset = -(~~$('html').css('padding-left').replace('px', '') + ~~$('body').css('margin-left').replace('px', '')),
    topOffset = -32;
    tt.className = 'ex-tooltip';
    document.body.appendChild(tt);  
    var data = {
    "xScale": "ordinal",
    "yScale": "linear",
                              
    "type": "bar",
    "main": [
                {
                "className": ".xchart-class-2",   
                "data": [   
                          <?php foreach ($najprodavanijiArtikli as $v){    
                              
                              if( $v->broj > 0)
                              {
                              ?>
                          
                                 {
                                   x: '<?php echo substr($v->naziv, 0, 15).'..'; ?>', 
                                  
                                   y:  parseInt('<?php echo $v->broj; ?>', 10)    
                                 },                                     
                          <?php }} ?>
                 
                        ]
                }
        ]
    };
    
    var opts = {
        "mouseover": function (d, i) {
            var pos = $(this).offset();
            $(tt).text(d.y)
                .css({top: topOffset + pos.top, left: pos.left + leftOffset + 10})
                .show();
        },
        "mouseout": function (x) {
            $(tt).hide();
        }
    };
    
         
    var myChart = new xChart('bar', data, '#xchart-2', opts);  
} 

$(document).ready(function() {  
     LoadXChartScript(DrawAllxCharts);
    // Required for correctly resize charts, when boxes expand
    var graphxChartsResize;
    $(".box").resize(function(event){
        event.preventDefault();
        clearTimeout(graphxChartsResize);
        graphxChartsResize = setTimeout(DrawAllxCharts, 500);
    }); 
    
    LoadSparkLineScript(DrawSparklineDashboard);

    <?php 
        if($this->session->userdata('licenca_ispravna') == 0)
        { ?>
            $('#spremi1').attr("disabled", true);    
            $('#spremi2').attr("disabled", true);    
        <?php }    
    ?>
    
    $('.close-link').click(function (event) {       
        CloseModalBox();
    });    
});



function fiskalizirajSve()
{
    event.preventDefault();

    var r = confirm("Zelite fiskalizirati racune?");
    if (r == true) 
    {
        $('.preloader2').show(); 
         //fiskalizacija
        $.post("<?php echo site_url().'fiskalizacija/fiskalsve'; ?>",{request: "RacunZahtjev"}, function(data) { 
                                           
           //dohvati pdf i prikazi ga na view report
            //posalji id dokumenta i id partnera ako postoji
            
            if (data != 'false') {
                
                var obj = $.parseJSON(data);   
                //reload pocetnu stranicu       
                pocetna();

                setTimeout(function() {
                    $('.preloader2').fadeOut('slow');
                }, 1000);
              
                $('#poruka').html(obj.poruka); 
                $('#poruka').show(); 
                setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                }, 10000);
                            
            }
            
        });
    }
    
}


function pocetna()
   { 
       $('.preloader').show();
       $.ajax({
           mimeType: 'text/html; charset=utf-8 general', // ! Need set mimeType only when run from local file
           url: "<?php echo base_url().'administracija/index'; ?>",
           type: 'GET',
           success: function(data) {
               $('#ajax-content').html(data);
               $('.preloader').hide();
           },
           error: function (jqXHR, textStatus, errorThrown) {
               alert(errorThrown);
           },
           dataType: "html",
           async: false
       });
   }

function noviRacunRonuda(id)
{
     //saljem ID dokumenta
 
       $('.preloader').show();
       
       
       $.post("<?php echo site_url().'administracija/pregled/dokument'; ?>", {id:id}, function(data) {
           
           if (data != 'false') {
               $('#ajax-content').html(data);
               $('.preloader').hide();
               
                $('#tablica').hide();
              
                $.post("<?php echo site_url().'dokument/dodaj/dokument'; ?>",{id:id}, function(data) {
                    if (data != 'false') {
                        $('#forma').empty();
                        $('#forma').html(data);
                        $('#forma').show();
                                             
                        $('#poruka').html(obj.poruka);    
                        setTimeout(function() {
                        $('#poruka').fadeOut('fast');
                        }, 10000);                    
                    } 

                });  
           }
           else
           {
               $('.preloader').hide();
           }
       });         
   
}

</script>
                                             

